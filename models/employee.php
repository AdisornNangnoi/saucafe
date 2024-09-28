<?php

class Employee
{
    //ตัวแปรที่ใช้เก็บการติดต่อฐานข้อมูล
    private $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $empId;
    public $empName;
    public $empImage;
    public $empPhonenum;
    public $empPassword;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //constructor
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }
    //----------------------------------------------
    //ฟังก์ชันการทำงานที่ล้อกับส่วนของ APIs

    //ฟังชันก์ตรวจสอบชื่อผู้ใช้และรหัสผ่าน
    public function checkUserPasswordEmp(){
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM employee_tb WHERE empPhonenum = :empPhonenum AND empPassword = :empPassword";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->empPhonenum = htmlspecialchars(strip_tags($this->empPhonenum));
        $this->empPassword = htmlspecialchars(strip_tags($this->empPassword));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":empPhonenum", $this->empPhonenum);
        $stmt->bindParam(":empPassword", $this->empPassword);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูลผู้ใช้ใหม่
    public function newEmp()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "INSERT INTO employee_tb (`empName`,`empPhonenum`, `empPassword`, `empImage`) VALUES (:empName, :empPhonenum, :empPassword, :empImage);";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->empName = htmlspecialchars(strip_tags($this->empName));
        $this->empPhonenum = htmlspecialchars(strip_tags($this->empPhonenum));
        $this->empPassword = htmlspecialchars(strip_tags($this->empPassword));
        $this->empImage = htmlspecialchars(strip_tags($this->empImage));
        

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":empPhonenum", $this->empName);
        $stmt->bindParam(":empPhonenum", $this->empPhonenum);
        $stmt->bindParam(":empPassword", $this->empPassword);
        $stmt->bindParam(":empPassword", $this->empImage);

        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updateEmp(){   
        $strSQL = "";
        if($this->empImage == ""){
        $strSQL = "UPDATE employee_tb SET `empName` = :empName, `empPhonenum` = :empPhonenum, `empPassword` = :empPassword WHERE `empId` = :empId;";

    }else{$strSQL = "UPDATE employee_tb SET `empName` = :empName, `empImage` = :empImage, `empPhonenum` = :empPhonenum, `empPassword` = :empPassword WHERE `empId` = :empId;";
}
        
        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->empId = intval(htmlspecialchars(strip_tags($this->empId)));
        $this->empName = htmlspecialchars(strip_tags($this->empName));
        if($this->empImage != ""){$this->empImage = htmlspecialchars(strip_tags($this->empImage));}
        $this->empPhonenum = htmlspecialchars(strip_tags($this->empPhonenum));
        $this->empPassword = htmlspecialchars(strip_tags($this->empPassword));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":empId", $this->empId);
        $stmt->bindParam(":empName", $this->empName);
        if($this->empImage != ""){$stmt->bindParam(":empImage", $this->empImage);}
        $stmt->bindParam(":empPhonenum", $this->empPhonenum);
        $stmt->bindParam(":empPassword", $this->empPassword);

        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
