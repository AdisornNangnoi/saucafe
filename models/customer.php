<?php

class Customer
{
    //ตัวแปรที่ใช้เก็บการติดต่อฐานข้อมูล
    private $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $custId;
    public $custName;
    public $custEmail;
    public $custImage;
    public $custPhonenum;
    public $custPassword;

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
    public function checkUserPasswordCust()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM customer_tb WHERE custPhonenum = :custPhonenum AND custPassword = :custPassword";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->custPhonenum = htmlspecialchars(strip_tags($this->custPhonenum));
        $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":custPhonenum", $this->custPhonenum);
        $stmt->bindParam(":custPassword", $this->custPassword);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูลผู้ใช้ใหม่
    public function newCust()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "INSERT INTO customer_tb ( `custName`,`custPhonenum`,`custPassword`, `custEmail`, `custImage`) VALUES (:custName, :custPhonenum, :custPassword, :custEmail, :custImage)";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->custName = htmlspecialchars(strip_tags($this->custName));
        $this->custPhonenum = htmlspecialchars(strip_tags($this->custPhonenum));
        $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));
        $this->custEmail = htmlspecialchars(strip_tags($this->custEmail));
        $this->custImage = htmlspecialchars(strip_tags($this->custImage));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters 
        $stmt->bindParam(":custName", $this->custName);
        $stmt->bindParam(":custName", $this->custPhonenum);
        $stmt->bindParam(":custPassword", $this->custPassword);
        $stmt->bindParam(":custEmail", $this->custEmail);
        $stmt->bindParam(":custEmail", $this->custImage);
        
        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updateCust(){   
        $strSQL = "";
        if($this->custImage == ""){
        $strSQL = "UPDATE customer_tb SET `custName` = :custName, `custEmail` = :custEmail, `custPhonenum` = :custPhonenum, `custPassword` = :custPassword WHERE `custId` = :custId;";

    }else{$strSQL = "UPDATE customer_tb SET `custName` = :custName, `custEmail` = :custEmail, `custImage` = :custImage, `custPhonenum` = :custPhonenum, `custPassword` = :custPassword WHERE `custId` = :custId;";
}
        
        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->custId = intval(htmlspecialchars(strip_tags($this->custId)));
        $this->custName = htmlspecialchars(strip_tags($this->custName));
        if($this->custImage != ""){$this->custImage = htmlspecialchars(strip_tags($this->custImage));}
        $this->custEmail = intval(htmlspecialchars(strip_tags($this->custEmail)));
        $this->custPhonenum = htmlspecialchars(strip_tags($this->custPhonenum));
        $this->custPassword = htmlspecialchars(strip_tags($this->custPassword));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":custId", $this->custId);
        $stmt->bindParam(":custName", $this->custName);
        $stmt->bindParam(":custEmail", $this->custEmail);
        if($this->custImage != ""){$stmt->bindParam(":custImage", $this->custImage);}
        $stmt->bindParam(":custPhonenum", $this->custPhonenum);
        $stmt->bindParam(":custPassword", $this->custPassword);

        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
