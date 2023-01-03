<?php
namespace Project\Bot\Model;

use Expertix\Bot\Log\BotLog;
use Expertix\Bot\Model\BaseBotModel;

use Expertix\Core\Db\DB;
use Expertix\Core\Util\Log;
use Expertix\Core\Util\UUID;

class ChatModel extends BaseBotModel
{
	public function createChat($request)
	{
		$botId = $request->required("botId");
		$username = $request->get("username");
		$chatId = $request->required("chatId");
		$chatDate = $request->get("date");
		$firstName = $request->get("firstName");
		$lastName = $request->get("lastName");
		$lang = $request->get("lang");

		$sql = "insert into bot_chat (botId, chatId, username, state, firstName, lastName, lang) values(?, ?, ?, ?, ?,?,?);";
		$params = [$botId, $chatId, $username, 1, $firstName, $lastName, $lang];
		DB::add($sql, $params);

		if (!$this->createLinkKey($chatId))
			return null;
		$chatArr = DB::getRow("select * from bot_chat where chatId=?", [$chatId]);
		return $chatArr;
	}
	
	public function updateUserName($chatId, $userName){
		return DB::set("update bot_chat set userName=? where chatId=?", [$userName, $chatId]);
	}
	public function updateFirstName($chatId, $firstName){
		return DB::set("update bot_chat set userName=? where chatId=?", [$firstName, $chatId]);
	}
	public function updateLang($chatId, $lang){
		return DB::set("update bot_chat set lang=? where chatId=?", [$lang, $chatId]);
	}
	public function updateLocation($chatId, $location){
		return DB::set("update bot_chat set location=? where chatId=?", [$location, $chatId]);
	}
	public function deleteAllChats(){
		return DB::set("delete from bot_chat", []);
	}

	private function createLinkKey($chatId)
	{
		//Log::d("crateLink for chat: '$chatId'");

		for ($i = 0; $i < 5; $i++) {
			try {
				$key = $this->generateKey($chatId);

				$sql = "update bot_chat set affKey='$key', dateLinkCreated = NOW() where chatId=?";
				$params = [$chatId];
				DB::set($sql, $params);
				return $key;
			} catch (\Throwable $th) {
			}
		}
		return null;
	}
	private function generateKey($chatId)
	{
		$key = UUID::gen_uuid($chatId, 4);
		//$key = $chatId; // For testing
		return $key;
	}
	public function activateChat($chatId)
	{
		$this->setChatState($chatId, 1);
	}
	public function deactivateChat($chatId)
	{
		$this->setChatState($chatId, 0);
	}

	// Link

	public function createChatLink($chatId2, $chatAffKey)
	{

		$parentChat = $this->getChatByAffKey($chatAffKey);
		if (!$parentChat) {
			throw new \Exception("Wrong chat key $chatAffKey", 1);
		}
		$parentChatId = $parentChat["chatId"];

		// Check if parent already exists
		$existingParentChatId = DB::getValue("select chatId1 from bot_chat_link where chatId2=?", [$chatId2]);
		if ($existingParentChatId && $existingParentChatId==$parentChatId) {
			return null;
		}
		
		// Insert link
		$sql = "insert into bot_chat_link (chatId1, chatId2) values(?, ?)";
		$params = [$parentChatId, $chatId2];
		DB::add($sql, $params);
		return true;
	}
	public function deleteChatLink($chatId)
	{
		$sql = "delete from bot_chat_link where chatId2=?";
		return DB::set($sql, [$chatId]);
	}

	//

	public function getChatById($chatId)
	{
		$sql = "select * from bot_chat where chatId=?";
		//Log::d("Get chat by id=$chatId");
		$params = [$chatId];
		return DB::getRow($sql, $params);
	}
	public function getChatByAffKey($link)
	{
		$sql = "select * from bot_chat where affKey=?";
		$params = [$link];
		return DB::getRow($sql, $params);
	}
	public function getLinkedChats123($chatId)
	{
		$sql = "select * from bot_chat order by chatId desc";
		$params = [$chatId];
		return DB::getAll($sql, $params);
	}
	public function getChats()
	{
		$sql = "select * from bot_chat order by chatId desc";

		return DB::getAll($sql, []);
	}


	public function updateCommandArgIndex($chatId, $argIndex)
	{
		$sql = "update bot_chat set lastCommandArgIndex=? where chatId=?";
		$params = [$argIndex, $chatId];
		return DB::set($sql, $params);
	}

	public function updateUserActivity($chatId, $commandText)
	{
		$sql = "update bot_chat set lastCommand=?, state=1, dateLastAnswer=NOW(), alarmLevel=0, dateLastAlarmNotify=now() where chatId=?";
		$params = [$commandText, $chatId];
		return DB::set($sql, $params);
	}

	public function getLastMessageId($chatId){
		$sql = "select max(messageId) from bot_chat_message where chatId=? order by created desc";
		return DB::getValue($sql, [$chatId]);
	}

	public function onCallbackAnswerRecieved($chatId, $messageId, $answerIndex, $rating, $answerMessage)
	{
		$sql = "update bot_chat_message set rating=?, answerText=case when answerText is not null then concat(answerText, '\n',  ?) else ? end, dateLastAnswer=NOW() where chatId=? and messageId=?";
		$params = [$rating, $answerMessage, $answerMessage, $chatId, $messageId];
		DB::set($sql, $params);

		return DB::getRow("select * from bot_chat_message where chatId=? and messageId=?", [$chatId, $messageId]);
	}
	public function onTextAnswerRecieved($chatId, $messageId, $answerMessage)
	{
		$sql = "update bot_chat_message set answerText=case when answerText is not null then concat(answerText, '\n',  ?) else ? end, dateLastAnswer=NOW() where chatId=? and messageId=?";
		$params = [$answerMessage, $answerMessage, $chatId, $messageId];
		DB::set($sql, $params);

		return DB::getRow("select * from bot_chat_message where chatId=? and messageId=?", [$chatId, $messageId]);
	}
	public function saveSendedMessage($chatId, $messageId, $contentGroupKey, $contentIndex, $contentConfig, $tags, $messageText, $messageImg)
	{
		$contentConfigStr = json_encode($contentConfig);
		$sql = "update bot_chat set state=2, contentConfig=?, dateLastPush=NOW(), dateLastAnswer=(if (state=1, NOW(), dateLastAnswer)), isNeedUpdate=0 where chatId=?";
		$params = [$contentConfigStr, $chatId];
		DB::set($sql, $params);

		$sql = "insert into bot_chat_message (chatId, messageId, contentGroup, contentIndex, tags, messageText, messageImg) values(?,?,?,?,?,?,?)";
		$params = [$chatId, $messageId, $contentGroupKey, $contentIndex, $tags, $messageText, $messageImg];
		BotLog::log($params);

		Log::d("Saved for $chatId: ", $contentConfigStr);

		return DB::add($sql, $params);
	}



	public function _onMessageRecieved($chatId, $contentIndex)
	{
		$sql = "update bot_chat set state=2, lastContentIndex=$contentIndex, dateLastPush=NOW(), isNeedUpdate=0 where chatId=?";
		$params = [$chatId];
		return DB::set($sql, $params);
	}


	public function onAlarmSended($chatId)
	{
		$sql = "update bot_chat set dateLastAlarmNotify=now() where chatId=?";
		$params = [$chatId];
		return DB::set($sql, $params);
	}

	public function setChatState($chatId, $state)
	{
		$sql = "update bot_chat set state=? where chatId=?";
		$params = [$state, $chatId];
		DB::set($sql, $params);
	}

	//
	public function getChatsForUpdate()
	{
		$period = "SECOND";
		$minPeriod = 1;
		//		$sql = "select * from bot_chat where TIMESTAMPDIFF($period, dateLastPush, now()) > $minPeriod order by chatId, dateLastPush desc";
		$sql = "update bot_chat set isNeedUpdate=1, dateLastAnswer=(if (state=1, NOW(), dateLastAnswer)) where botId=1 and TIMESTAMPDIFF($period, dateLastPush, now()) > $minPeriod and state>0";
		//$sql = "update bot_chat set isNeedUpdate=1, dateLastAnswer=(if (state=1, NOW(), dateLastAnswer)) where botId=1 and TIMESTAMPDIFF($period, dateLastPush, now()) > $minPeriod and state>0";
		DB::set($sql, []);

		$sql = "select * from bot_chat where isNeedUpdate=1 and state>0 order by chatId";
		return DB::getAll($sql, []);
	}
	public function getChatsForAlarm()
	{
		$period = "MINUTE";
		$minAlarmPeriod1 = 1;
		$minAlarmPeriod2 = 2;
		$minAlarmNotifyPeriod = 1;

		//$sql = "select * from bot_chat where now()-dateLastPush>100 order by chatId, dateLastPush desc";
		$sql = "update bot_chat set alarmLevel=if(TIMESTAMPDIFF($period, dateLastAnswer, now())>=$minAlarmPeriod2, 2, if(TIMESTAMPDIFF($period, dateLastAnswer, now())>=$minAlarmPeriod1,1,0)) where state=2 and TIMESTAMPDIFF($period, dateLastAnswer, now())>=$minAlarmPeriod1";
		DB::set($sql, []);
		//$sql = "update bot_chat set alarmLevel=2 where state=2 and TIMESTAMPDIFF($period, dateLastAnswer, now())>$minAlarmPeriod2 and TIMESTAMPDIFF($period, dateLastNotify, now())>$minAlarmNotifyPeriod";
		//DB::set($sql, []);

		//$sql = "select * from bot_chat_link chat_link left join bot_chat chat1 on chat_link.chatId1=chat1.chatId and chat1.alarmLevel=1 inner join bot_chat chat2 on chat_link.chatId2=chat2.chatId order by chatId";
		$sql = "select chat2.chatId as toChatId, chat1.userName as fromUserName, chat1.alarmLevel as alarmLevel from bot_chat chat1 inner join bot_chat_link chat_link on chat_link.chatId1=chat1.chatId and chat1.alarmLevel>0 inner join bot_chat chat2 on chat_link.chatId2=chat2.chatId where chat1.state>0 and chat2.state>0 and TIMESTAMPDIFF($period, chat2.dateLastAlarmNotify, now())>=$minAlarmNotifyPeriod";
		//$sql = "select * from bot_chat where alarmLevel>0";
		return DB::getAll($sql, []);
	}
	
	public function getStatForLinkedChat($chatId)
	{
		$linkedChats = DB::getAll("select bl.chatId1 as chatId, bot_chat.* from bot_chat inner join bot_chat_link bl on bl.chatId1=bot_chat.chatId where bl.chatId2=?", [$chatId]);
		if (!$linkedChats) {
			return null;
		}

		$result = [];
		foreach ($linkedChats as $key => $chat) {
			$linkedChatId = $chat["chatId"];
			$username = $chat["userName"];
			$result[$username] = ["user"=>$chat, "stat"=> $this->getAggregateStatForChat($linkedChatId)];
		}

		return $result;
	}
	public function getStatForChat($chatId)
	{
		
		$result = [];
		$result[] = $this->getAggregateStatForChat($chatId);
		

		return $result;
	}
	public function getDetailedStatForChat($chatId, $sqlWhereDateParam="")
	{
		$sqlWhereDate = $sqlWhereDateParam;
		$sql = "select m.*, timestampdiff(MINUTE, created, dateLastAnswer) as delay from bot_chat_message m where chatId=? $sqlWhereDate order by created desc";
		return DB::getAll($sql, [$chatId]);
	}
	private function getAggregateStatForChat($chatId)
	{
		//$sql = "select chatId, contentGroup, sum(rating), count(*), avg(rating) from bot_chat_message where chatId=? group by chatId, contentGroup";
		$sql = "select chatId, contentGroup, sum(rating) as rating, count(*) as `all`, count(case when dateLastAnswer is not null then 1 end) as `answered`, count(case when dateLastAnswer is null then 1 end) as `not_answered`, max(dateLastAnswer) dateLastAnswer, timestampdiff(MINUTE, created, dateLastAnswer) as dateAnswer, ceil(avg(timestampdiff(MINUTE, created, dateLastAnswer))) as avg from bot_chat_message where chatId=? group by chatId, contentGroup;";
		return DB::getAll($sql, [$chatId]);
	}
}