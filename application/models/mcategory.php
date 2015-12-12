<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 1/7/15
 * Time: 7:08 PM
 */

class Mcategory extends CI_Model {

    var $cate_id;
    var $cate_name;
    var $cate_order;
    var $cate_comment;


    public function __construct($id, $name, $order, $comment)
    {
        parent::__construct();

        $this->cate_id = $id;
        $this->cate_name = $name;
        $this->cate_order = $order;
        $this->cate_comment = $comment;
    }

    public static function getCategoryList($table)
    {

        if($table == "UserType") {

            $category1 = new Mcategory(1, "Sysadmin", 1, "");
            $category2 = new Mcategory(2, "Teacher", 2, "");
            $category3 = new Mcategory(3, "Student", 3, "");
            $category4 = new Mcategory(4, "Parent", 4, "");
            $category5 = new Mcategory(5, "Staff", 5, "");

            $list = array($category1, $category2, $category3, $category4, $category5);
            return $list;

        } else if($table == "State") {

            $list = array(

                new Mcategory("AL", "Alabama", 1, ""),
                new Mcategory("AK", "Alaska", 2, ""),
                new Mcategory("AZ", "Arizona", 3, ""),
                new Mcategory("AR", "Arkansas", 4, ""),
                new Mcategory("CA", "California", 5, ""),
                new Mcategory("CO", "Colorado", 6, ""),
                new Mcategory("CT", "Connecticut", 7, ""),
                new Mcategory("DE", "Delaware", 8, ""),
                new Mcategory("FL", "Florida", 9, ""),
                new Mcategory("GA", "Georgia", 10, ""),
                new Mcategory("HI", "Hawaii", 11, ""),
                new Mcategory("ID", "Idaho", 12, ""),
                new Mcategory("ID", "Illinois", 13, ""),
                new Mcategory("IN", "Indiana", 14, ""),
                new Mcategory("IA", "Iowa", 15, ""),
                new Mcategory("KS", "Kansas", 16, ""),
                new Mcategory("KY", "Kentucky", 17, ""),
                new Mcategory("LA", "Louisiana", 18, "")
            );
            return $list;
            /*
                 Maine
            ME
                 Maryland
            MD
                 Massachusetts
            MA
                 Michigan
            MI
                 Minnesota
            MN
                 Mississippi
            MS
                 Missouri
            MO
                 Montana
            MT
                 Nebraska
            NE
                 Nevada
            NV
                 New Hampshire
            NH
                 New Jersey
            NJ
                 New Mexico
            NM
                 New York
            NY
                 North Carolina
            NC
                 North Dakota
            ND
                 Ohio
            OH
                 Oklahoma
            OK
                 Oregon
                 OR
                 Pennsylvania
            PA
                 Rhode Island
            RI
                 South Carolina
            SC
                 South Dakota
            SD
                 Tennessee
            TN
                 Texas
             TX
                 Utah
            UT
                 Vermont
            VT
                 Virginia
             VA
                 Washington
             WA
                 West Virginia
            WV
                 Wisconsin
            WI
                 Wyoming
             WY
            */
        }

    }
}