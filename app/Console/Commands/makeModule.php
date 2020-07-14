<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class makeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource {name} {attributes?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a basic CRUD module.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var array The data types that can be created in a migration.
     */
    private $dataTypes = [
        'string', 'integer', 'boolean', 'bigIncrements', 'bigInteger',
        'binary', 'boolean', 'char', 'date', 'dateTime', 'float', 'increments',
        'json', 'jsonb', 'longText', 'mediumInteger', 'mediumText', 'nullableTimestamps',
        'smallInteger', 'tinyInteger', 'softDeletes', 'text', 'time', 'timestamp',
        'timestamps', 'rememberToken',
    ];

    /**
     * @var \string[][]
     */
    private $fakerMethods = [
        'string' => ['method' => 'words', 'parameters' => '2, true'],
        'integer' => ['method' => 'randomNumber', 'parameters' => ''],
    ];

    /**
     * @var array $columnProperties Properties that can be applied to a table column.
     */
    private $columnProperties = [
        'unsigned', 'index', 'nullable'
    ];

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Composer $composer
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $name = Str::singular(strtolower($this->argument('name')));

        $this->info('You have provided the following manifest information:');
        $this->line("Resource: {$name}");

        if ($this->confirm('Is the resource name correct?')) {
            $this->generate($name);
        } else {
            $name = $this->askValid('Enter the Resource name?', 'resource_name', ['required', 'min:3']);
            $name = Str::singular(strtolower($name));

            $this->generate($name);
        }

        return true;
    }

    private function generate($name): void
    {
        $this->createModel($name);
        $this->createMigration($name);
        $this->createController($name);
        $this->appendRoutes($name);
        $this->createModelFactory($name);
    }

    private function createModelFactory($name): bool
    {
        $model = $this->modelName($name);
        $filename = Str::singular(ucfirst($model)) . 'Factory.php';

        $stub = $this->files->get(base_path('storage/stubs/factory.stub'));
        $stub = str_replace('MODELNAME', $model, $stub);

        $class = 'App\\' . $model;
        $model = new $class;

        $stub = str_replace('ATTRIBUTES', $this->buildFakerAttributes($model->migrationAttributes()), $stub);

        $this->files->put(database_path('/factories/' . $filename), $stub);

        $this->info('Created model factory');

        return true;
    }

    public function buildFakerAttributes($attributes)
    {
        $faker = '';

        foreach ($attributes as $attribute) {
            $formatter = $this->fakerMethods[$this->getFieldTypeFromProperties($attribute['properties'])];

            $method = $formatter['method'];
            $parameters = $formatter['parameters'];

            $faker .= "'".$attribute['name']."' => \$faker->".$method. '(' .$parameters. '),' . PHP_EOL . '        ';
        }

        return rtrim($faker);
    }

    private function appendRoutes($name): void
    {
        $modelTitle = ucfirst($name);
        $modelName = Str::plural(strtolower($name));

        $newRoutes = $this->files->get(base_path('storage/stubs/routes.stub'));
        $newRoutes = str_replace(['|MODEL_TITLE|', '|MODEL_NAME|', '|CONTROLLER_NAME|'], [$modelTitle, $modelName, $modelTitle . 'Controller'], $newRoutes);

        $this->files->append(base_path('routes/web.php'), $newRoutes);

        $this->info('Added routes for ' . $modelTitle);
    }

    protected function buildMigration($name)
    {
        $className = 'Create' . ucfirst(Str::plural($name)). 'Table';
        $table = strtolower(Str::plural($name));
        $class = 'App\\' . $name;
        $model = new $class;

        $stub = $this->files->get(base_path('storage/stubs/migration.stub'));
        $stub = str_replace([
            'MIGRATION_CLASS_PLACEHOLDER',
            'TABLE_NAME_PLACEHOLDER',
            'MIGRATION_COLUMNS_PLACEHOLDER'
        ], [
            $className,
            $table,
            $this->buildTableColumns($model->migrationAttributes())
        ], $stub);

        return $stub;
    }

    /**
     * Create and store a new Model to the filesystem.
     *
     * @param $name
     * @return bool
     * @throws FileNotFoundException
     */
    private function createModel($name): bool
    {
        $modelName = $this->modelName($name);
        $filename = $modelName . '.php';

        if ($this->files->exists(app_path($filename))) {
            $this->error('Model already exists!');
            return false;
        }

        $model = $this->buildModel($name);

        $this->files->put(app_path('/' . $filename), $model);

        $this->info($modelName . ' Model created');

        return true;
    }

    private function createMigration($name): bool
    {
        $filename = $this->buildMigrationFilename($name);

        if ($this->files->exists(database_path($filename))) {
            $this->error('Migration already exists!');
            return false;
        }

        $migration = $this->buildMigration($name);

        $this->files->put(
            database_path('/migrations/' . $filename),
            $migration
        );

        if (env('APP_ENV') !== 'testing') {
            $this->composer->dumpAutoloads();
        }

        $this->info('Created migration ' . $filename);

        return true;
    }

    private function createController($modelName): bool
    {
        $filename = Str::singular(ucfirst($modelName)) . 'Controller.php';

        if ($this->files->exists(app_path('Http/' . $filename))) {
            $this->error('Controller already exists!');
            return false;
        }

        $stub = $this->files->get(base_path('storage/stubs/controller.stub'));

        $stub = str_replace([
            'MyModelClass',
            'MyModelUpper',
            'MyModelLower',
            'MyModelLowerSingular'
        ], [
            ucfirst($modelName),
            ucfirst($modelName),
            strtolower($modelName),
            Str::singular(ucfirst($modelName))
        ], $stub);

        $this->files->put(app_path('Http/Controllers/' . $filename), $stub);

        $this->info('Created controller ' . $filename);

        return true;
    }

    public function convertModelToTableName($model): string
    {
        return Str::plural(Str::snake($model));
    }

    public function buildMigrationFilename($model): string
    {
        $table = $this->convertModelToTableName($model);

        return date('Y_m_d_his') . '_create_' . $table . '_table.php';
    }

    /**
     * @param $name
     * @return mixed
     * @throws FileNotFoundException
     */
    protected function buildModel($name)
    {
        $stub = $this->files->get(base_path('storage/stubs/model.stub'));
        $stub = $this->replaceClassName($name, $stub);
        $stub = $this->addMigrationAttributes($this->argument('attributes'), $stub);
        $stub = $this->addModelAttributes('fillable', $this->argument('attributes'), $stub);
        $stub = $this->addModelAttributes('hidden', $this->argument('attributes'), $stub);

        return $stub;
    }

    /**
     * @param $name
     * @param $stub
     * @return string|string[]
     */
    private function replaceClassName($name, $stub)
    {
        return str_replace('NAME_PLACEHOLDER', ucfirst($name), $stub);
    }

    /**
     * @param $text
     * @param $stub
     * @return string|string[]
     */
    private function addMigrationAttributes($text, $stub)
    {
        $attributesAsArray = $this->parseAttributesFromInputString($text);
        $attributesAsText = $this->convertArrayToString($attributesAsArray);

        return str_replace('MIGRATION_ATTRIBUTES_PLACEHOLDER', $attributesAsText, $stub);
    }

    /**
     * Convert a pipe-separated list of attributes to an array.
     *
     * @param string $text The Pipe separated attributes
     * @return array
     */
    public function parseAttributesFromInputString($text): array
    {
        $parts = explode('|', $text);
        $attributes = [];

        foreach ($parts as $part) {
            $components = explode(':', $part);
            $attributes[$components[0]] = isset($components[1]) ? explode(',', $components[1]) : [];
        }

        return $attributes;
    }

    /**
     * Convert a PHP array into a string version.
     *
     * @param $array
     *
     * @return string
     */
    public function convertArrayToString($array): string
    {
        $string = '[';

        foreach ($array as $name => $properties) {
            $string .= '[';
            $string .= "'name' => '" . $name . "',";

            $string .= "'properties' => [";

            foreach ($properties as $property) {
                $string .= "'".$property."', ";
            }

            $string = rtrim($string, ', ');
            $string .= ']';
            $string .= '],';
        }

        $string = rtrim($string, ',');
        $string .= ']';

        return $string;
    }

    public function addModelAttributes($name, $attributes, $stub)
    {
        $attributes = '[' . collect($this->parseAttributesFromInputString($attributes))
        ->filter(static function($attribute) use ($name) {
            return in_array($name, $attribute, true);
        })->map(static function ($name) {
            return "'" . $name . "'";
        })->values()->implode(', ') . ']';

        return str_replace(strtoupper($name) . '_PLACEHOLDER', $attributes, $stub);
    }

    public function buildTableColumns($attributes)
    {
        return rtrim(collect($attributes)->reduce(function($column, $attribute) {
            $fieldType = $this->getFieldTypeFromProperties($attribute['properties']);

            if ($length = $this->typeCanDefineSize($fieldType)) {
                $length = $this->extractFieldLengthValue($attribute['properties']);
            }

            $properties = $this->extractAttributePropertiesToApply($attribute['properties']);

            return $column . $this->buildSchemaColumn($fieldType, $attribute['name'], $length, $properties);
        }));
    }

    /**
     * Get the column field type based from the properties of the field being created.
     *
     * @param array $properties
     * @return string
     */
    private function getFieldTypeFromProperties($properties): string
    {
        $type = array_intersect($properties, $this->dataTypes);

        if (! $type) {
            return 'string';
        }

        return $type[0];
    }

    /**
     * Can the data type have it's size controlled within the migration?
     *
     * @param string $type
     * @return bool
     */
    private function typeCanDefineSize($type): bool
    {
        return $type === 'string' || $type === 'char';
    }

    /**
     * Extract a numeric length value from all properties specified for the attribute.
     *
     * @param array $properties
     * @return int $length
     */
    private function extractFieldLengthValue($properties)
    {
        foreach ($properties as $property) {
            if (is_numeric($property)) {
                return $property;
            }
        }

        return 0;
    }

    /**
     * Get the column properties that should be applied to the column.
     *
     * @param $properties
     * @return array
     */
    private function extractAttributePropertiesToApply($properties): array
    {
        return array_intersect($properties, $this->columnProperties);
    }

    /**
     * Create a Schema Builder column.
     *
     * @param string $fieldType The type of column to create
     * @param string $name Name of the column to create
     * @param int $length Field length
     * @param array $traits Additional properties to apply to the column
     * @return string
     */
    private function buildSchemaColumn($fieldType, $name, $length = 0, $traits = []): string
    {
        return sprintf("\$table->%s('%s'%s)%s;" . PHP_EOL . '            ',
            $fieldType,
            $name,
            $length > 0 ? ", $length" : '',
            implode('', array_map(static function ($trait) {
                return '->' . $trait . '()';
            }, $traits))
        );
    }

    /**
     * Build a Model name from a word.
     *
     * @param string $name
     * @return string
     */
    private function modelName($name): string
    {
        return ucfirst($name);
    }

    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([$fieldName => $value], [
            $fieldName => $rules
        ]);

        return $validator->fails() ? $validator->errors()->first($fieldName) : null;
    }
}
