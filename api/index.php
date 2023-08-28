<?php
include "api.php";
include "functions.php";
require "../rb/rb.php";
R::setup('mysql:host=localhost;dbname=rb_it', 'root', 'root'); //for both mysql or mariaDB//rb_pharmacy
R::freeze(true);
R::useJSONFeatures(TRUE);

header('Content-type: json/aplication');

if (!R::testConnection()) {
  echo 'нет подключения';
}
$recivedData = json_decode(file_get_contents("php://input"));
$func = new Functions;
if ($recivedData->action == 'getTableNames') {
  $tables = R::getAll('SHOW TABLES');
  foreach ($tables as $table) {
    $data[] = $table;
  }
  echo json_encode(($data));
}
if ($recivedData->action == 'deleteRowById') {
  $fromVueParamId = $recivedData->selectedId;
  $fromVueParamTableName = $recivedData->selectedTableName;
  ///$rows = deleteRowById($fromVueParamId, $fromVueParamTableName);

  $rows = $func->deleteRowById($fromVueParamId, $fromVueParamTableName);
  foreach ($rows as $row) {
    $data[] = $row;
  }
  echo json_encode(($data));
}
if ($recivedData->action == 'insertIntoTable') {
  $fromVueParamTableName = $recivedData->selectedTableName;
  $fromVueInsertData = $recivedData->insertInto;

  echo $func->insertIntoTable($fromVueParamTableName, $fromVueInsertData);
}
if ($recivedData->action == 'updateTableRow') {
  $fromVueParamTableName = $recivedData->selectedTableName;
  $fromVueInsertData = $recivedData->insertInto;

  $fromVueParamTableName = $recivedData->selectedTableName;
  $fromVueRowId = $recivedData->rowId;
  $fromVueUpdateData = $recivedData->updateData;

  echo $func->updateTableRow($fromVueParamTableName, $fromVueRowId, $fromVueUpdateData);
}

if ($recivedData->action == 'registCompanyAndAdmCompany') {
  $fromVueDataCompany = $recivedData->companyData;
  $fromVueDataAdmin = $recivedData->adminData;

  echo $func->registCompanyAndAdmCompany($fromVueDataCompany, $fromVueDataAdmin);
}
if ($recivedData->action == 'authorizationUser') {
  $fromVueDataAuth = $recivedData->authForm;
  //var_dump($fromVueDataAuth->userLogin);
  $respons = $func->chekUserAndAuthorizationUser($fromVueDataAuth);
  $userAndCompanyInfo = array("userInfo" => $respons[0], "companyInfo" => $respons[1]);
  echo json_encode($userAndCompanyInfo);
  
}
if ($recivedData->action == 'createUser') {
  $fromVueNewUserData = $recivedData->newUserData;
  $fromVueUserCompanyData = $recivedData->companyData;

  echo $func->createUser($fromVueNewUserData, $fromVueUserCompanyData);
}
if ($recivedData->action == 'getCompanyUsers') {
  $fromVueCompanyid = $recivedData->companyId;
  

  echo json_encode($func->getCompanyUsers($fromVueCompanyid));
}
if ($recivedData->action == 'createNewTask') {
  $fromVueTask = $recivedData->newTaskData;
  $fromVueFromUserid = $recivedData->fromUser;

  echo json_encode($func->createNewTask($fromVueTask,$fromVueFromUserid));
}
if ($recivedData->action == 'getCreatedTask') {
  $fromVueFromUserid = $recivedData->userId;

  echo json_encode($func->getCreatedTask($fromVueFromUserid));
}
if ($recivedData->action == 'getUserById') {
  $fromVueFromUserid = $recivedData->userId;

  echo json_encode($func->getUserById($fromVueFromUserid));
}
if ($recivedData->action == 'getMyTasks') {
  $fromVueFromUserid = $recivedData->userId;

  echo json_encode($func->getMyTasks($fromVueFromUserid));
}
if ($recivedData->action == 'setTaskStatus') {
  $fromVueid = $recivedData->taskId;
  $fromVueStatus = $recivedData->status;

  echo json_encode($func->setTaskStatus($fromVueid,$fromVueStatus));
}
if ($recivedData->action == 'countTimeTask') {
  $fromVueid = $recivedData->taskId;
  $fromVueStatus = $recivedData->status;
  $taskTime = $func->countTimeTask($fromVueid,$fromVueStatus);
  echo json_encode($taskData);
}
//countTimeTask