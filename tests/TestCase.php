<?php

namespace Tests;

use Closure;
use App\Models\User;
use Illuminate\Support\Fluent;
use App\Models\Reports\Report;
use App\Models\Reports\ReportType;
use App\Models\ReportFile\ReportFile;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\Schema\Blueprint;
use App\Models\ReportFile\ReportFileType;
use App\Models\AnalysisRule\AnalysisRule;
use Illuminate\Database\Schema\SQLiteBuilder;
use App\Models\AnalysisRule\AnalysisRuleType;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\DynamicAttributes\DynamicAttributeType;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->hotfixSqlite();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Laravel: Hotfix for SQLite Drop Foreign Exception
     *
     * Note:
     * This example is for when you are using in-memory sqlite for tests!
     *
     * Important:
     * For PHPUnit 9, it is important that you call the hotfix
     * method before the parent constructor in the constructor method.
     */
    public function hotfixSqlite()
    {
        \Illuminate\Database\Connection::resolverFor('sqlite',
            function ($connection, $database, $prefix, $config) {
                return new class($connection, $database, $prefix, $config)
                    extends SQLiteConnection {
                    public function getSchemaBuilder()
                    {
                        if ($this->schemaGrammar === null) {
                            $this->useDefaultSchemaGrammar();
                        }

                        return new class($this) extends SQLiteBuilder {
                            protected function createBlueprint($table, Closure $callback = null)
                            {
                                return new class($table, $callback) extends Blueprint {
                                    public function dropForeign($index)
                                    {
                                        return new Fluent();
                                    }
                                };
                            }
                        };
                    }
                };
            });
    }

    public function authenticated_user_admin() : ?User {
        // authentification du user
        $user = User::find(1);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'admin123',
        ]);

        $this->assertAuthenticated();

        return $user;
    }

    /**
     * @param $title
     * @return Report
     */
    protected function create_new_report($title = null)
    {
        $reporttype = ReportType::defaultReport()->first();
        return Report::createNew($title ?? "New Report",$reporttype,"new report desc");
    }

    /**
     * @param $name
     * @return DynamicAttribute
     */
    protected function create_new_dynamicattribute($name = null)
    {
        return $this->create_new_report("new report")
            ->addDynamicAttribute($name ?? "New Dynamic Attribute",DynamicAttributeType::string()->first());
    }

    /**
     * @param $file_name
     * @return ReportFile
     */
    public function create_new_reportfile($file_name) {
        return $this->create_new_report("new report")
            ->addReportFile(ReportFileType::txt()->first(),$file_name);
    }

    public function create_new_analysisrule($title = null): AnalysisRule {
        return AnalysisRule::createNew($this->create_new_dynamicattribute(),AnalysisRuleType::threshold()->first(),$title ?? "New AnalysisRule");
    }
}
