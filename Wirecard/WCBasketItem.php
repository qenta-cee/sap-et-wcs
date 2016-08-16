<?php

namespace WireCardSeamlessBundle\Wirecard;

/**
 * The BasketItem class contains the required parameters for using BasketItems, which are used in some payment types. (e.g. PayPal)
 * NOT IN USE YET!
 * @author clic
 *
 */
class WCBasketItem {
	

	/**
	 * Unique ID of article n in shopping cart.
	 * Within fingerprint: Required if used.
	 * @var string Alphanumeric with special characters.
	 */
	private $basketItemArticleNumber;
	
	/**
	 * Product description of article n in shopping cart.
	 * Within fingerprint: Required if used.
	 * @var string Alphanumeric with special characters.
	 */
	private $basketItemDescription;
	
	/**
	 * Items count of article n in shopping cart.
	 * Within fingerprint: Required if used.
	 * @var int Numeric
	 */
	private $basketItemQuantity;
	
	/**
	 * Tax amount of article n in shopping cart.
	 * Within fingerprint: Required if used.
	 * @var float Amount
	 */
	private $basketItemTax;
	
	/**
	 * Price per unit of article n in shopping cart without taxes.
	 * Within fingerprint: Required if used.
	 * @var int Amount
	 */
	private $basketItemUnitPrice;
	
	/**
	 * Returns an array containing the parameters (names as key - as defined by the Wirecard specification).
	 * @param int $itemNumber
	 * @return array
	 */
	
	public function getAttributeArray($itemNumber){
		return array(
				"basketItem".$itemNumber."ArticleNumber"=>$this->basketItemArticleNumber,
				"basketItem".$itemNumber."Description"=>$this->basketItemDescription,
				"basketItem".$itemNumber."Quantity"=>$this->basketItemQuantity,
				"basketItem".$itemNumber."Tax"=>$this->basketItemTax,
				"basketItem".$itemNumber."UnitPrice"=>$this->basketItemUnitPrice,				
		);
	}
	public function getBasketItemArticleNumber() {
		return $this->basketItemArticleNumber;
	}
	public function setBasketItemArticleNumber( $basketItemArticleNumber) {
		$this->basketItemArticleNumber = $basketItemArticleNumber;
		return $this;
	}
	public function getBasketItemDescription() {
		return $this->basketItemDescription;
	}
	public function setBasketItemDescription( $basketItemDescription) {
		$this->basketItemDescription = $basketItemDescription;
		return $this;
	}
	public function getBasketItemQuantity() {
		return $this->basketItemQuantity;
	}
	public function setBasketItemQuantity($basketItemQuantity) {
		$this->basketItemQuantity = $basketItemQuantity;
		return $this;
	}
	public function getBasketItemTax() {
		return $this->basketItemTax;
	}
	public function setBasketItemTax($basketItemTax) {
		$this->basketItemTax = $basketItemTax;
		return $this;
	}
	public function getBasketItemUnitPrice() {
		return $this->basketItemUnitPrice;
	}
	public function setBasketItemUnitPrice($basketItemUnitPrice) {
		$this->basketItemUnitPrice = $basketItemUnitPrice;
		return $this;
	}
	
	
	
	
}