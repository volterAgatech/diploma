<?php
class Functions
{
  function getTableColByName($param)
  {
    $table = R::getAll('SHOW COLUMNS FROM ' . $param);
    return $table;
  }
  function getTableRowByName($param)
  {
    $table = R::getAll('SELECT * FROM ' . $param);
    return $table;
  }
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
  function updateTableRow($tablename, $rowId, $formData)
  {
    $row = R::load($tablename, $rowId);
    // Заполняем объект свойствами
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
    if(!empty($checkUser)){
      $hashPass = $checkUser->pass;
      $verifyPwd = password_verify($authFormData->userPass, $hashPass);
      if($verifyPwd){
        return $checkUser;
      }else{
        return "003";
      }
    }else{
      return "003";
    }
    
  }
}
