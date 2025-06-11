# BoraWallet

`BoraWallet` is a PHP library for initiating mobile wallet payments such as MPESA STK push using a custom API. It builds on the BoraService base class and provides an easy way to initiate and manage wallet transactions in your application.

## Installation

To install the package, you can use Composer:

```bash
composer require ilebora/borawallet
```

## Configuration

Before using `BoraWallet`, you'll need to provide your API credentials (API key, user ID, and display name). There are two ways to do this:

1. **Using Environment Variables (`.env` file)**  
   The package can automatically read the API credentials from your `.env` file using [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv).

2. **Using Getter and Setter Methods**  
   Alternatively, you can set the credentials directly via getter and setter methods.

### Example `.env` file

Create a `.env` file in the root of your project with the following contents:

```plaintext
BORA_API_KEY=your_api_key
BORA_USER_ID=your_user_id
BORA_DISPLAY_NAME=your_display_name
```

### Example Usage

Below is an example of how to use the `BoraWallet` class.

```php
<?php
require 'vendor/autoload.php';

use ILEBORA\BoraWallet;

try {
    // Option 1: Using the constructor to load from environment variables
    $wallet = new BoraWallet();

    // Option 2: Alternatively, set credentials using setters
    // $wallet = (new BoraWallet())
    //     ->setApiKey('your_api_key')
    //     ->setUserID('your_user_id')
    //     ->setDisplayName('your_display_name');

    // Option3: Set the API version you are taregeting
    // $wallet->setApiVersion('1.1');

    // Set other properties
    $wallet->setPhone('0113703323')
        ->setAmount(250)
         // ->setBackLink('https://yourdomain.com/back')
        // ->setOnSuccess('success_callback_url')
        // ->setOnFailure('failure_callback_url')
        ;

    // Generate
    $formHtml = $wallet->getCheckoutForm();

    // Handle the response
    echo $formHtml;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Methods Overview

- **`__construct()`**  
  Optionally loads credentials from environment variables. Throws an exception if required credentials are missing.

- **`setApiVersin($apiVersion)`**  
  Sets the API version to use.

- **`setApiKey($apiKey)`**  
  Sets the API key used for authentication.

- **`setUserID($userID)`**  
  Sets the user ID used for authentication.

- **`setDisplayName($displayName)`**  
  Sets the display name used for Bora Wallet.

- **`setPhone($phone)`**  
  Sets the recipient phone number.

- **`setAmount($amount = 100)`**  
  Set the payment amount. Defaults to 100.
  
- **`getCheckoutForm()`**  
  Returns a JSON-encoded HTML form for initiating a wallet payment.

- **`setBackLink($link)`**  
  Sets the URL to be added as the backlink to your app.

- **`setOnSuccess($onSuccess)`**  
  Sets the URL to be called on success.

- **`setOnFailure($onFailure)`**  
  Sets the URL to be called on failure.

- **`getBalance()`**  
  (To be implemented)
  
- **`getWithdrawalForm()`**  
  (To be implemented)

### Example Callback Response

The response returned by the API might look like this:

```json
{
  "status": "success",
  "html": "<form>...</form>",
  "message": "STK push initiated"
}
```

Extract and embed the html field in your application to initiate payment.

---

## License

This package is open-source and licensed under the MIT License. Feel free to modify and contribute to the project.

---

### Notes:

1. **Error Handling**:  
   If the required credentials are missing, the constructor will throw an exception. It's important to handle this gracefully in your application.

2. **Security Considerations**:  
   It's recommended to store sensitive information like the API key and user ID in environment variables (via `.env` file) instead of hardcoding them into your source code.
