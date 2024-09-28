<?php

class Category
{
    //ตัวแปรที่ใช้เก็บการติดต่อฐานข้อมูล
    private $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $catId;
    public $catName;


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
    public function getAllCategory()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM category_tb";

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูลมื้ออาหาร
    public function inSertCategory()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "  INSERT INTO category_tb (`catName`) VALUES (:catName);";

        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->catName = htmlspecialchars(strip_tags($this->catName));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":catName", $this->catName);


        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //ฟังก์ชันลบข้อมูลบันทึกการกิน
    public function deleteCategory()
    {
        $strSQL = "DELETE FROM category_tb WHERE `catId` = :catId;";
        $this->catId = intval(htmlspecialchars(strip_tags($this->catId)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":catId", $this->catId);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชันแก้ไขข้อมูลบันทึกการกิน
    public function updateCategory()
    {
        $strSQL = "UPDATE category_tb SET `catName` = :catName WHERE `catId` = :catId;";
        //ตรวจสอบค่าที่ถูกส่งจาก Client/User ก่อนที่จะกำหนดให้กับ parameters (:????)
        $this->catId = intval(htmlspecialchars(strip_tags($this->catId)));
        $this->catName = htmlspecialchars(strip_tags($this->catName));
        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);
        //เอาที่ผ่านการตรวจแล้วไปกำหนดให้กับ parameters
        $stmt->bindParam(":catId", $this->catId);
        $stmt->bindParam(":catName", $this->catName);


        //สั่งให้ SQL ทำงาน และส่งผลลัพธ์ว่าเพิ่มข้อมูลสําเร็จหรือไม่
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
