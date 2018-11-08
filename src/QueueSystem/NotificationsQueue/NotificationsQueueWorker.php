<?php


namespace Tutorial\QueueSystem\Notifications;


use PhpAmqpLib\Message\AMQPMessage;

class NotificationsQueueWorker extends NotificationsQueue {
	
	private $workerId;
	
	private $queueName;
	
	public function withWorkerId($workerId){
		$this->workerId = $workerId;
	}
	
	/**
	 * @param $queueName
	 *
	 * @throws \ErrorException
	 */
	public function consume($queueName){
		global $shouldStop;
		
		$this->queueName = $queueName;
		
		$this->channel->basic_qos(null, 1, null );
		$this->channel->basic_consume($queueName, '', false, false, false, false, [$this, 'process']);
		
		echo "\n[W{$this->workerId}] Waiting for incoming messages\n";
		
		while (count($this->channel->callbacks) && !$shouldStop) {
			$this->channel->wait(null, true, 1);
		}
		
		$this->channel->close();
		$this->connection->close();
	}
	
	/**
	 * @param AMQPMessage $msg
	 */
	function process(AMQPMessage $msg){
		echo "\r\n[W{$this->workerId}] Message Received ... \r\n";
		
		print_r(json_decode($msg->getBody()));
		
		/** @noinspection PhpUnusedLocalVariableInspection */
//		$childId = $this->workerId;
		/** @noinspection PhpUnusedLocalVariableInspection */
//		$jobName = $this->queueName;
//		include __DIR__ . "/../../../public/queues.formbuilder.demo/topics/02.Forking/processes/job.php";
		
		/** @noinspection PhpUndefinedMethodInspection */
		$msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag']);
	}
}