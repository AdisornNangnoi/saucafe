<?php

class MenuItem
{
    //ตัวแปรที่ใช้เก็บการติดต่อฐานข้อมูล
    private $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $itemId;
    public $itemName;
    public $catId;
    public $itemImage;
    public $itemSize;
    public $itemPrice;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //constructor
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }
    //----------------------------------------------
    //ฟังก์ชันการทำงานที่ล้อกับส่วนของ APIs


    //ฟังก์ชันดึงข้อมูลทั้งหมดจากตาราง diaryfood
    public function getAllMenuItem()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM menu_item_tb";

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }
    //ฟังชันก์ตรวจสอบชื่อผู้ใช้และรหัสผ่าน
    public function checkUserPasswordCust()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM customer_tb WHERE itemSize = :itemSize AND itemPrice = :itemPrice";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->itemSize = htmlspecialchars(strip_tags($this->itemSize));
        $this->itemPrice = htmlspecialchars(strip_tags($this->itemPrice));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":itemSize", $this->itemSize);
        $stmt->bindParam(":itemPrice", $this->itemPrice);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูลผู้ใช้ใหม่
    public function insertMenuItem()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "INSERT INTO menu_item_tb (itemName, itemSize, itemPrice, catId, itemImage) VALUES (:itemName, :itemSize, :itemPrice, :catId, :itemImage)";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->itemName = htmlspecialchars(strip_tags($this->itemName));
        $this->itemSize = htmlspecialchars(strip_tags($this->itemSize));
        $this->itemPrice = htmlspecialchars(strip_tags($this->itemPrice));
        $this->catId = intval(htmlspecialchars(strip_tags($this->catId)));
        $this->itemImage = htmlspecialchars(strip_tags($this->itemImage));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters 
        $stmt->bindParam(":itemName", $this->itemName);
        $stmt->bindParam(":itemSize", $this->itemSize);
        $stmt->bindParam(":itemPrice", $this->itemPrice);
        $stmt->bindParam(":catId", $this->catId);
        $stmt->bindParam(":itemImage", $this->itemImage);
        
        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    //ฟังก์ชันลบข้อมูลบันทึกการกิน
    public function deleteMenuItem()
    {
        $strSQL = "DELETE FROM menu_item_tb WHERE `itemId` = :itemId;";
        $this->itemId = intval(htmlspecialchars(strip_tags($this->itemId)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":itemId", $this->itemId);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateMenuItem(){   
        $strSQL = "";
        if($this->itemImage == ""){
            $strSQL = "UPDATE menu_item_tb SET itemName = :itemName, catId = :catId, itemSize = :itemSize, itemPrice = :itemPrice WHERE itemId = :itemId;";
        }else{
            $strSQL = "UPDATE menu_item_tb SET itemName = :itemName, catId = :catId, itemSize = :itemSize, itemPrice = :itemPrice, itemImage = :itemImage WHERE itemId = :itemId;";
        }

        
        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->itemName = htmlspecialchars(strip_tags($this->itemName));
        $this->catId = intval(htmlspecialchars(strip_tags($this->catId)));
        $this->itemSize = htmlspecialchars(strip_tags($this->itemSize));
        $this->itemPrice = htmlspecialchars(strip_tags($this->itemPrice));
        $this->itemId = intval(htmlspecialchars(strip_tags($this->itemId)));
        $this->itemImage = htmlspecialchars(strip_tags($this->itemImage));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":itemName", $this->itemName);
        $stmt->bindParam(":catId", $this->catId);
        $stmt->bindParam(":itemSize", $this->itemSize);
        $stmt->bindParam(":itemPrice", $this->itemPrice);
        $stmt->bindParam(":itemId", $this->itemId);
        $stmt->bindParam(":itemImage", $this->itemImage);

        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
