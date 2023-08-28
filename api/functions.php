<?php
class Functions
{
  function deleteRowById($id, $tablename)
  {
    //DELETE FROM `cities` WHERE `id` = 13
    R::exec('DELETE FROM ' . $tablename . ' WHERE id = ' . $id);
    $table = R::getAll('SELECT * FROM ' . $tablename);
    return $table;
  }
  function insertIntoTable($tablename, $formData)
  {
    $table = R::dispense($tablename);
    // Заполняем объект свойствами
    //var_dump($table);
    foreach ($formData as $key => $value) {
      print "$key => $value\n";
      $table->$key = $value;
    }
    R::store($table);
  }
  function createUser($userData, $companyData)
  {
    $table = R::dispense('users');
    $checkUser = R::findOne('users', 'login = ?', [$userData->login]);
    if (!empty($checkUser)) {
      return "001";
    } else {
      $userData->id_company = $companyData->id;
      $userData->company_key = $companyData->company_key;
      // Заполняем объект свойствами
      $userData->rule = 100;
      $userData->pass = password_hash($userData->pass, PASSWORD_DEFAULT);
      foreach ($userData as $key => $value) {
        print "$key => $value\n";
        $table->$key = $value;
      }
      R::store($table);
    }
  }
  function updateTableRow($tablename, $rowId, $formData)
  {
    $row = R::load($tablename, $rowId);
    // Заполняем объект свойствами
    if($formData->pass){
      $formData->pass = password_hash($formData->pass, PASSWORD_DEFAULT);
    }
    foreach ($formData as $key => $value) {
      print "$key => $value\n";
      $row->$key = $value;
    }
    R::store($row);
  }

  function registCompanyAndAdmCompany($companyData, $adminData)
  {
    //to do получить дату и отправить в базу данных информацию о компании и ее созадтеле
    //создать записть о создателе как админе, его дату обработать(шифр пароля)
    //$companyR = R::dispense("about_company");
    $nameCompany = $companyData->name_company;
    $admLogin = $adminData->login;
    $checkCompany = R::findOne('companys', 'name_company = ?', [$nameCompany]);
    $checkAdm = R::findOne('users', 'login = ?', [$admLogin]);
    $func = new Functions;
    //$errorMSG = "001";
    if (!empty($checkCompany) || !empty($checkAdm)) {
      return "001";
    } else if ($adminData->pass != $adminData->pass2) {
      return "002";
    } else {
      //to do зарегать компанию и админа
      //удаление проверочного пароля из объекта 
      unset($adminData->pass2);
      //добавление к записи компании имя автора(администратора)

      $uniqIdCompany = $nameCompany . uniqid();
      $companyData->company_key = $uniqIdCompany;
      $companyData->admin_name = $adminData->name;
      $func->insertIntoTable('companys', $companyData);

      //добавление к записи юзера id компании
      $findNewComp = R::findOne('companys', 'name_company = ?', [$nameCompany]);
      $findIdComp = $findNewComp->id;
      $adminData->company_key = $uniqIdCompany;
      $adminData->id_company = $findIdComp;
      //добавление к записи юзера его роль
      $adminData->rule = 900;
      $adminData->text_rule = 'Администратор';
      $adminData->pass = password_hash($adminData->pass, PASSWORD_DEFAULT);
      $func->insertIntoTable("users", $adminData);
    }
  }
  function chekUserAndAuthorizationUser($authFormData)
  {
    //to do найти пользователя по логину и паролю
    $userLogin = $authFormData->userLogin;
    $checkUser = R::findOne('users', 'login = ?', [$userLogin]);
    $checkUserCompany = R::findOne('companys', 'id = ?', [$checkUser->id_company]);
    if (!empty($checkUser)) {
      $hashPass = $checkUser->pass;
      $verifyPwd = password_verify($authFormData->userPass, $hashPass);
      if ($verifyPwd) {
        //создать объект с информацией о пользователе и о его компании
        $array1 = array($checkUser, $checkUserCompany);

        return $array1;
      } else {
        return "003";
      }
    } else {
      return "003";
    }
  }
  
  function getCompanyUsers($idCompany)
  {
    $users = R::getAll('SELECT * FROM users WHERE id_company = '. $idCompany . ' AND rule = 100');
    return $users;
  }
  function createNewTask($taskData,$fromUserId)
  {
    $func = new Functions;
    $taskData->from_user_id = $fromUserId;
    $taskData->task_status = "created";
    $func->insertIntoTable("tasks", $taskData);
  }
  function getCreatedTask($fromUserId){
    //вернуть задачи где from_user_id == авторизированный пользователь
    
    $users = R::getAll("SELECT * FROM tasks WHERE from_user_id = ". $fromUserId . " AND task_status = 'created' OR task_status = 'stareted' OR task_status = 'stoped'");
    
    return $users;
  }
  function getMyTasks($userId){
    //вернуть задачи где to_user_id == авторизированный пользователь
    $users = R::getAll("SELECT * FROM tasks WHERE to_user_id = ". $userId . " AND task_status != 'closed'");
    return $users;
  }
  function getCompliteTasks($userId){
    //вернуть задачи где status == авторизированный пользователь
    $status = 'closed';
    $users = R::getAll('SELECT * FROM tasks WHERE to_user_id = '. $userId . ' AND task_status ==' . $status);
    return $users;
  }
  function getUserById($userId){
    //вернуть задачи где status == авторизированный пользователь;
    $checkUser = R::findOne('users', 'id = ?', [$userId]);
    return $checkUser;
  }
  function setTaskStatus($rowId, $status)
  {
    $row = R::load('tasks', $rowId);
    // Заполняем объект свойствами
    $row->task_status = $status;
    if($status == 'started'){
      $today = date("Y-m-d H:i:s");
      $row->started_btn = $today;
    }
    R::store($row);
  }
  function countTimeTask($rowId,$status){
    //формируем время визита в дате и в часах
    //получаем дату старта выполнения задачи
    //вычесляем разницу возвращаем
    $row = R::load('tasks', $rowId);
    // Заполняем объект свойствами
    if($status == 'started'){
      $today = date("Y-m-d H:i:s");
      $startedDate = $row->started_btn;
      $first_date = new DateTime($today);
      $second_date = new DateTime($startedDate);
      $difference = $first_date->diff($second_date);
      $days = $difference->d;
      $hour = $difference->h;
      $min = $difference->i;
      $sec = $difference->s;
      $string1 = $days.':'.$hour.':'.$min.':'.$sec;

        //return $array1;
      $row->visited_data = $string1;
    }
    R::store($row);
  }
}
