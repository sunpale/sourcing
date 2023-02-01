<?php namespace App\Schemas\Grammars;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\SqlServerGrammar;
use Illuminate\Support\Fluent;

class CustomSqlServerGrammar extends SqlServerGrammar
{
    /**
     * Compile a drop default constraint command.
     *
     * @param Blueprint $blueprint
     * @param Fluent $command
     * @return string
     */
    public function compileDropDefaultConstraint(Blueprint $blueprint, Fluent $command): string
    {
        $columns = "'".implode("','", $command->columns)."'";

        $tableName = $this->getTablePrefix().$blueprint->getTable();

        $sql = "DECLARE @sql VARCHAR(MAX) = '';";
        $sql .= "SELECT @sql += 'ALTER TABLE [dbo].[{$tableName}] DROP CONSTRAINT ' + OBJECT_NAME([default_object_id]) + ';' ";
        $sql .= 'FROM sys.columns ';
        $sql .= "WHERE [object_id] = OBJECT_ID('[dbo].[{$tableName}]') AND [name] in ({$columns}) AND [default_object_id] <> 0;";
        $sql .= 'EXEC(@sql)';

        return $sql;
    }
    /**
     * Compile the command to drop all foreign keys.
     *
     * @return string
     */
    public function compileDropAllForeignKeys(): string
    {
        return "DECLARE @sql VARCHAR(MAX) = N'';
            SELECT @sql += 'ALTER TABLE '
                + QUOTENAME(OBJECT_SCHEMA_NAME(parent_object_id)) + '.' + + QUOTENAME(OBJECT_NAME(parent_object_id))
                + ' DROP CONSTRAINT ' + QUOTENAME(name) + ';'
            FROM sys.foreign_keys;

            EXEC sp_executesql @sql;";
    }

    /**
     * Compile the command to drop all views.
     *
     * @return string
     */
    public function compileDropAllViews(): string
    {
        return "DECLARE @sql VARCHAR(MAX) = N'';
            SELECT @sql += 'DROP VIEW ' + QUOTENAME(OBJECT_SCHEMA_NAME(object_id)) + '.' + QUOTENAME(name) + ';'
            FROM sys.views;

            EXEC sp_executesql @sql;";
    }
    /**
     * Create the column definition for a string type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeString(Fluent $column): string
    {
        return "varchar({$column->length})";
    }
    /**
     * Create the column definition for a tiny text type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeTinyText(Fluent $column): string
    {
        return 'varchar(255)';
    }
    /**
     * Create the column definition for a text type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeText(Fluent $column)
    {
        return 'varchar(max)';
    }

    /**
     * Create the column definition for a medium text type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeMediumText(Fluent $column): string
    {
        return 'varchar(max)';
    }

    /**
     * Create the column definition for a long text type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeLongText(Fluent $column): string
    {
        return 'varchar(max)';
    }
    /**
     * Create the column definition for an enumeration type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeEnum(Fluent $column): string
    {
        return sprintf(
            'varchar(255) check ("%s" in (%s))',
            $column->name,
            $this->quoteString($column->allowed)
        );
    }
    /**
     * Create the column definition for an IP address type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeIpAddress(Fluent $column): string
    {
        return 'varchar(45)';
    }

    /**
     * Create the column definition for a MAC address type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeMacAddress(Fluent $column): string
    {
        return 'varchar(17)';
    }
}
