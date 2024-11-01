<?php
// AccountInterface
interface AccountInterface {
    public function deposit($amount);
    public function withdraw($amount);
    public function getBalance();
}

// BankAccount
class BankAccount implements AccountInterface {
    const MIN_BALANCE = 0;

    protected $balance;
    protected $currency;

    public function __construct($currency = "USD") {
        $this->balance = self::MIN_BALANCE;
        $this->currency = $currency;
    }

    public function deposit($amount) {
        if ($amount <= 0) {
            throw new Exception("Сума поповнення має бути позитивною.");
        }
        $this->balance += $amount;
    }

    public function withdraw($amount) {
        if ($amount <= 0) {
            throw new Exception("Сума для зняття має бути позитивною.");
        }
        if ($amount > $this->balance) {
            throw new Exception("Недостатньо коштів.");
        }
        $this->balance -= $amount;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function getCurrency() {
        return $this->currency;
    }
}

// SavingsAccount
class SavingsAccount extends BankAccount {
    public static $interestRate = 0.02;

    public function applyInterest() {
        $this->balance += $this->balance * self::$interestRate;
    }
}

// Client code - testing
try {
    $account = new BankAccount("USD");
    echo "Поточний баланс: {$account->getBalance()} {$account->getCurrency()}\n";

    $account->deposit(100);
    echo "Після поповнення: {$account->getBalance()} {$account->getCurrency()}\n";

    $account->withdraw(30);
    echo "Після зняття: {$account->getBalance()} {$account->getCurrency()}\n";

    $account->withdraw(100); // Это вызовет исключение
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n";
}

try {
    $savingsAccount = new SavingsAccount("EUR");
    echo "\nНакопичувальний рахунок: {$savingsAccount->getBalance()} {$savingsAccount->getCurrency()}\n";

    $savingsAccount->deposit(200);
    echo "Після поповнення: {$savingsAccount->getBalance()} {$savingsAccount->getCurrency()}\n";

    $savingsAccount->applyInterest();
    echo "Після застосування відсоткової ставки: {$savingsAccount->getBalance()} {$savingsAccount->getCurrency()}\n";

    $savingsAccount->withdraw(250);
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n";
}
?>
