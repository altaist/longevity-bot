<?php

namespace Project\Bot\Model;

use Expertix\Core\Db\DB;

class ChatActionModel {
	public function createAction($chatId, $messageId, $message){
		
		$sql = "insert into bot_chat_action(chatId, messageId, message ) values(?, ?, ?);";
		$params = [$chatId, $messageId, $message];
		$id = DB::add($sql, $params);
		return $id;
	}
	
}