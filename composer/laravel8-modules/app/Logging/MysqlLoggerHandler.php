<?php
/**
 * 日志写入mysql表logs
 */

namespace App\Logging;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Illuminate\Support\Facades\Auth;


class MysqlLoggerHandler extends \Monolog\Handler\AbstractProcessingHandler
{

    public $table;
    public $connection;

    public function __construct($level = Logger::DEBUG, bool $bubble = true)
    {
        $this->table = env('DB_LOG_TABLE', 'logs');
        $this->connection = env('DB_LOG_CONNECTION', 'logs');
        parent::__construct($level, $bubble);
        // $this->table = env('DB_LOG_TABLE', 'logs');
        // $this->connection = env('DB_LOG_CONNECTION', env('DB_CONNECTION', 'mysql'));

        // parent::__construct($level, $bubble);
    }
    /**
     * Summary of write
     * @param array $record
     * @return void
     * 
     * Declaration of Logger\Monolog\Handler\MysqlHandler::write(array $record) 
     * must be compatible with 
     * Monolog\Handler\AbstractProcessingHandler::write(array $record): void
     */
    protected function write(array $record): void
    {
        // var_dump($record);
        try {
            $data = [
                'instance' => gethostname(),
                'message' => $record['message'],
                'channel' => $record['channel'],
                'level' => $record['level'],
                'level_name' => $record['level_name'],
                'context' => json_encode($record['context']),
                'remote_addr' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
                'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
                'created_by' => Auth::id() > 0 ? Auth::id() : null,
                'created_at' => $record['datetime']->format('Y-m-d H:i:s')
            ];

            DB::connection($this->connection)->table($this->table)->insertGetId($data);
            // if (isset($record['context']['exception']) && is_object($record['context']['exception'])) {
            //     $record['context']['exception'] = (array) $record['context']['exception'];
            // }
            // $record['request_data'] = request()->all() ?? [];
            // $log = [
            //     // 'guid' => \Str::uuid(),
            //     // 'title' => $record['message'],
            //     'level' => $record['level'],
            //     'level_name' => $record['level_name'],
            //     'message' => $record['message'],
            //     // 'request_host' => $record['request_host'] ?? request()->getSchemeAndHttpHost(),
            //     // 'request_uri' => $record['request_uri'] ?? request()->getRequestUri(),
            //     // 'request_method' => $record['request_method'] ?? request()->getMethod(),
            //     // 'request_ip' => request()->getClientIp(),
            //     // 'request_data' => json_encode($record['request_data']),
            //     // 'context' => isset($record['context']) ? json_encode($record['context']) : '',
            //     // 'created_at' => $record['datetime']->format('Y-m-d H:i:s'),
            //     // 'updated_at' => $record['datetime']->format('Y-m-d H:i:s'),
            // ];
            // if ($this->connection && $this->table) {
            //     // TODO: Implement write() method.
            //     \DB::connection($this->connection)->table($this->table)->insert(
            //         $log
            //     );
            // }
        } catch (\Exception $e) {
            // var_dump($e);
            \Log::channel('daily')->error($e->getMessage() . $e->getFile() . $e->getTraceAsString());
        }
    }
}
