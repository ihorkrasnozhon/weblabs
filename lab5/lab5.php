<?php
class Product {
    public $name;
    public $description;
    protected $price;

    public function __construct($name, $price, $description) {
        $this->name = $name;
        $this->setPrice($price);
        $this->description = $description;
    }

    public function setPrice($price) {
        if ($price >= 0) {
            $this->price = $price;
        } else {
            throw new Exception("Ціна не може бути від'ємною");
        }
    }

    public function getPrice() {
        return $this->price;
    }

    public function getInfo() {
        return "Назва: {$this->name}<br>Ціна: {$this->price}<br>Опис: {$this->description}";
    }
}

class DiscountedProduct extends Product {
    private $discount;

    public function __construct($name, $price, $description, $discount) {
        parent::__construct($name, $price, $description);
        $this->discount = $discount;
    }

    public function getDiscountedPrice() {
        return $this->price - ($this->price * $this->discount / 100);
    }

    public function getInfo() {
        $discountedPrice = $this->getDiscountedPrice();
        return "Назва: {$this->name}<br>Ціна зі знижкою: {$discountedPrice}<br>Опис: {$this->description}<br>Знижка: {$this->discount}%";
    }
}

class Category {
    public $categoryName;
    private $products = [];

    public function __construct($categoryName) {
        $this->categoryName = $categoryName;
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function getProducts() {
        $result = "Категорія: {$this->categoryName}<br>Товари:<br>";
        foreach ($this->products as $product) {
            $result .= $product->getInfo() . "<br><br>";
        }
        return $result;
    }
}

$product1 = new Product("iPhone 13", 20000, "Новий, 128/4гб");
$product2 = new DiscountedProduct("Samsung S24", 10000, "Уживаний, 256/8гб", 10);

$category = new Category("Електроніка");
$category->addProduct($product1);
$category->addProduct($product2);

echo $product1->getInfo();
echo "<br><br>";
echo $product2->getInfo();
echo "<br><br>";
echo $category->getProducts();
?>
