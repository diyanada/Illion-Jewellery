<?php 

class paypal{

    public $_InvoiceId = NULL;
    public $_Amount = NULL;
    public $_Discount = NULL;
    public $_Tax = NULL;
    public $_ItemId = NULL;
    public $_ItemName = NULL;

    function __construct($_BasketID) {

        require_once (dirname(__FILE__) . '/system_strings.php');
        $_Sql = new system_strings();
        
        require_once (dirname(__FILE__) . '/../DbClass/Basket.php');
        $Basket = new Basket();
        $BasketMapper = new BasketMapper();
        
        require_once (dirname(__FILE__) . '/../DbClass/Item.php');
        $Item = new Item();
        $ItemMapper = new ItemMapper();

        $_Connection = $_Sql -> connect();

        if ($_Connection == false) {
            exit($_Sql -> error());
        }
        
        $Basket -> _Id = $_BasketID;
        
        $Basket = $BasketMapper ->Select($Basket, $_Connection);
        if ($Basket == false) {
            
            exit($BasketMapper -> error());
        }
        
        $this -> _InvoiceId = $Basket -> _InvoiceId;
        $this -> _Amount = $Basket -> _Amount;
        $this -> _Discount = $Basket -> _Discount;
        $this -> _Tax = $Basket -> _Tax;
        $this -> _ItemId = $Basket -> _ItemId;
        
        $Item -> _Id = $this -> _ItemId;
        
        $Item = $ItemMapper ->Select($Item, $this -> _Connection);
        if ($Item == false) {
            
            exit($ItemMapper -> error());
        }
        
        $this -> _ItemName = $Item -> __DisplayName;
    }
    
}