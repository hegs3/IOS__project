<?php
class DBRemovePhotoAll {
  private $conn;

  function __construct($uuid) {
    require_once dirname(__FILE__) . '/DBConnect.php';
    $db = new DBConnect();
    $dbCheck = 'account';
    $this->conn = $db->connect($dbCheck);

    $sql = 'SELECT id FROM uuidinfo WHERE uuid = \''.$uuid.'\'';
    $stmt = $this->conn->prepare($sql);
    $re = $stmt->execute();

    $re = $stmt->get_result();
    $tablename = $re->fetch_assoc();

    $stmt->fetch();
    $stmt->close();

    $namerule1 = 'a';    //PICTUREtable 이름을 강제로 명명하기 위한 문자열
    $namerule2 = 'b';    //TAGtable 이름을 강제로 명명하기 위한 문자열
    $tablename = (string)$tablename['id'];    //uuid의 순번과 동일시
    $tableID = $tablename;
    define('TABLEID', $tableID);// TABLEID
  }
  public function removePhotoAll($auth) {

      // TABLEID   :: b1
      //uuid ::22293B74-1FFA-481E-819C-994B66BFBEB4
      $tableID = 'a'.TABLEID;

      $stmt = mysqli_select_db($this->conn, "tagpicture_picture");

      $sql = 'DELETE FROM
                '.$tableID.'
              WHERE auth = (?)';

      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("i", $auth);

      $result = $stmt->execute();
      $stmt->fetch();
      $stmt->close();

      if ($result) {
        return true;
      } else {
        return false;
      }
  }
}
?>
