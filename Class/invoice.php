<?php 

class invoice{
    
    private $_Sql = NULL;
    private $_Query = NULL;
    private $_Connection = NULL;     
    
    
    public $_InvoiceId = NULL;
    public $_Price = NULL;
    public $_BasketId = NULL;
    public $_UserId = NULL; 
    public $_ItemId = NULL;
    public $_Quantity = NULL;
    public $_Amount = NULL;
    public  $_Discount = NULL;
    public $_Tax = NULL;

    private function tr($data) {
        return "<tr>" . $data . "</tr>";
    }
    
    private function pre($data) {
        return "<pre>" . $data . "</pre>";
    }

    private function td($data, $class = NULL, $align = NULL, $col = 0, $row = 0) {
        
        return "<td class = '" . $class . "' "
                . "align = '" . $align . "' " 
                . "colspan = '" . $col . "' "
                . "rowspan = '" . $row . "' >"
                . $data . "</td>";
    }

    private function th($data) {
        
        return "<th>" . $data . "</th>";
    }    
    
    private function NonReadValue($Name, $Start = 6){
        
        $Name = substr($Name, $Start);
        $Name = (int)$Name;
        $Name = str_split($Name);        
        
        $_Return = NULL;
        
        for ($index = 0; $index < count($Name); $index++) {
            
            $_Return .= chr(65 + $Name[$index]);
        }
        
        return $_Return;
    }   
    
    private function BillTable() {
        
        $_Return = $this ->Table("Bill");
        
        $_Tr = $this->th("Description");
        $_Tr .= $this->th("Unit Cost");
        $_Tr .= $this->th("Quantity");
        $_Tr .= $this->th("Total");
        
        $_Return .= $this ->tr($_Tr);
        
        $Item = $this -> GetItem();
        
        $_Total = $Item -> _Price * $this -> _Quantity;
        
        $_Tr = $this->td("(" . $Item -> _Id . ") " . $Item -> _DisplayName);
        $_Tr .= $this->td($Item -> _Price);
        $_Tr .= $this->td($this -> _Quantity);
        $_Tr .= $this->td($_Total);
        
        $_Return .= $this ->tr($_Tr);
        
        $_Tr = $this->td("Sub Total", "", "", 3);
        $_Tr .= $this->td($_Total);
        
        $_Return .= $this ->tr($_Tr);
        
        $_ObjArray = $this -> GetOffer();
        
        $_OfferTax = array();
        $_OfferDisscount = array();
        
        for ($index = 1; $index < count($_ObjArray); $index++) {
            
            if($_ObjArray[$index] -> _IsIncrease == "Tax"){
                $value = $_Total * ($_ObjArray[$index] -> _Percentage / 100);
                array_push($_OfferTax, $value);
            }
            else {
                $value = ($_Total * ($_ObjArray[$index] -> _Percentage / 100)) * -1;
                array_push($_OfferDisscount, $value);
            }            
            
            
            $_Tr = $this->td($_ObjArray[$index] -> _Name, "", "", 3);
            $_Tr .= $this->td($value);
        
            $_Return .= $this ->tr($_Tr);
        }
        
        $this -> _Amount = $_Total;
        $this -> _Discount = array_sum($_OfferDisscount);
        $this -> _Tax = array_sum($_OfferTax);
        
        $_Tr = $this->td("Total", "", "", 3);
        $this -> _Price = ($_Total + $this -> _Discount) + $this -> _Tax;  
                        
        $_Tr .= $this->td(number_format($this -> _Price, 2));
        
        $_Return .= $this ->tr($_Tr);
        
        $_Return .= $this -> TableEnd();
        return $_Return;
    }
    
    private function GetItem() {
        
        require_once (dirname(__FILE__) . '/../DbClass/Item.php');
        $Item = new Item();
        $ItemMapper = new ItemMapper();
        
        $Item -> _Id = $this -> _ItemId;
        
        $Item = $ItemMapper ->Select($Item, $this -> _Connection);
        if ($Item == false) {
            
            exit($ItemMapper -> error());
        }
        
        return $Item;
    }
    
    private function GetOffer() {
        
        require_once (dirname(__FILE__) . '/../DbClass/ItemOfferType.php');
        $ItemOfferType = new ItemOfferType();
        $ItemOfferTypeMapper = new ItemOfferTypeMapper();
        
        return $ItemOfferTypeMapper ->Search($ItemOfferType, $this -> _Connection);
    }

    function __construct() {

        require_once (dirname(__FILE__) . '/system_strings.php');
        $this -> _Sql = new system_strings();

        require_once (dirname(__FILE__) . '/query.php');
        $this -> _Query = new query();

        $this -> _Connection = $this -> _Sql -> connect();

        if ($this -> _Connection == false) {
            exit($this -> _Sql -> error());
        }
    }
    
    function __destruct() {
        
        unset($this -> _Sql);
        unset($this -> _Query);       
        
    }
    
    Public function HeadDesign() {
        
        $_Return = NULL;
        
        require_once (dirname(__FILE__) . '/interface_magic.php');
        $int_mg = new interface_magic(); 
        
        $_Return .= $this ->tr($this ->td("INVOICE", "InviceTopic", "center", 2));
        
        $Logo = "<img width = '120px' height = '70px' src = '" . $int_mg->external_source("Image/Logo.jpg") . "'";
        $line = $this ->td("Illion Jewellery", "CompnyName", "left");
        $line .= $this ->td($Logo, "", "right", 0, 2);
        $_Return .= $this ->tr($line);       
        
        $line = "Illion Jewellery <br />";
        $line .= "Bristol, <br />";
        $line .= "UK. <br />";
        $line .= "+9400000000000 <br />";   
        $line .= "Illion@gmial.com <br />";
        $_Return .= $this ->tr($this ->td($line , "CompnyAdd"));
        
        $line = "";
        $line = "Invoice ID : (" . $this -> _InvoiceId . ")"
                . "<br />Date : " . $today = date("F j, Y.");
        
        $tr = $this ->td($line, "InvoiceDetails", "right", 2);
        $_Return .= $this ->tr($tr);
        
        unset($int_mg);
        
        return $_Return;
    }
    
    Public function Table($class, $align = "center", $border = 0) {
        
        $_Return = "<div class = '" . $class . "Div'>";
        $_Return .=  "<table align = '" . $align . "' border = '" . $border . "' class = '" . $class . "Table'>";
        
        return $_Return;
    }
    
    public function UserDesign() {
        
        $_Return = NULL;
        
        require_once (dirname(__FILE__) . '/../DbClass/UserDetails.php');
        $UserDetails = new UserDetails();
        $UserDetailsMapper = new UserDetailsMapper();
        
        $UserDetails -> _UserId = $this -> _UserId;
        
        $UserDetails = $UserDetailsMapper ->Select($UserDetails, $this -> _Connection);
        
        $Name = $UserDetails -> _FirstName . " " . $UserDetails -> _LastName;
        $tr = $this ->td($Name, "UsersName", "left", 2);
        $_Return = $this ->tr($tr);
        
        $tr = $this ->td( $this ->pre($UserDetails -> _Address), "UsersAdd", "left", 2);
        $_Return = $this ->tr($tr);
        
        unset($UserDetails);
        unset($UserDetailsMapper);
        
        return $_Return;
    }
    
    public function Bill() {
        
        $line = $this ->td($this ->BillTable(), "", "", 2);
        return $this ->tr($line); 
    }    
    
    public function TableEnd() {
        
        $_Return = "</table></div>";
        
        return $_Return;
    }  
    
    public function InvoiceId() {
        
        $InvoiceID = $this ->NonReadValue($this -> _BasketId) . "-";
        $InvoiceID .= $this ->NonReadValue(date("Ymd"), 0) . "-";
        $InvoiceID .= $this ->NonReadValue($this -> _ItemId) . "-";
        $InvoiceID .= $this ->NonReadValue($this -> _UserId);
        
        $this -> _InvoiceId = $InvoiceID;
        
    }
}