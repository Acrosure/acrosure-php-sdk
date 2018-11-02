# acrosure-php-sdk

![Acrosure](https://raw.githubusercontent.com/Acrosure/acrosure-js-sdk/master/static/Acrosure-color.png)

PHP SDK for connecting with Acrosure Insurance Gateway

## Installation

Install via [Composer](https://getcomposer.org/):

`composer require acrosure/acrosure-php-sdk`

## Getting Started

Import AcrosureClient into your project.

```php
require_once dirname(__FILE__).'/vendor/autoload.php';
```

Instantiate with an API key from [Acrosure Dashboard](https://dashboard.acrosure.com).

```php
$acrosureClient = new AcrosureClient([
  "token" => "<your_api_key>",
  "endpointBase" => "<endpoint_base>" // as optional
]);
```

## Basic Usage

AcrosureClient provides several objects such as `application`, `product`, etc. and associated APIs.

Any data will be inside an response object with `data` key, along with meta data, such as:

```json
{
  "data": { ... },
  "status": "ok",
  ...
}
```

### Application

#### Get

Get application with specified id.

```php
$application = $acrosureClient->getApplicationManager()->get("<application_id>");
```

#### Create

Create an application.

```php
$createdApplication = $acrosureClient->getApplicationManager()->create([
  "product_id" => "<product_id>", // required
  "basic_data" => json_decode('{}'),
  "package_options" => json_decode('{}'),
  "additional_data" => json_decode('{}'),
  "package_code" => "<package_code>",
  "attachments": => []
]);
```

#### Update

Update an application.

```php
$updatedApplication = $acrosureClient->getApplicationManager()->update([
  "application_id" => "<application_id>", // required
  "basic_data": json_decode('{}'),
  "package_options": json_decode('{}'),
  "additional_data": json_decode('{}'),
  "package_code": "<package_code>",
  "attachments": []
]);
```

#### Get packages

Get current application available packages.

```php
$packages = $acrosureClient->getApplicationManager()->getPackages("<application_id>");
```

#### Select package

Select package for current application.

```php
$updatedApplication = $acrosureClient->getApplicationManager()->selectPackage([
  "application_id" => "<application_id>",
  "package_code" => "<package_code>"
]);
```

#### Get package

Get selected package of current application.

```php
$currentPackage = $acrosureClient->getApplicationManager()->getPackage(
  "<application_id>"
);
```

#### Submit

Submit current application.

```php
$submittedApplication = $acrosureClient->getApplicationManager()->submit(
  "<application_id>"
);
```

#### Confirm

Confirm current application.

```php
$confirmedApplication = $acrosureClient->getApplicationManager()->confirm(
  "<application_id>"
);
```

#### List

List your applications (with or without query).

```php
$applications = $acrosureClient->getApplicationManager()->getList(searchParams);
```

### Product

#### Get

Get product with specified id.

```php
$product = $acrosureClient->getProductManager()->get("<product_id>");
```

#### List

List your products (with or without query).

```php
$products = $acrosureClient->getProductManager()->getList(searchParams);
```

### Policy

#### Get

Get policy with specified id.

```php
$policy = $acrosureClient->getPolicyManager()->get("<policy_id>");
```

#### List

List your policies (with or without query).

```php
$policies = $acrosureClient->getPolicyManager()->getList(searchParams);
```

### Data

#### Get

Get values for a handler (with or without dependencies, please refer to Acrosure API Document).

```php
// Without dependencies
$values = $acrosureClient->getDataManager()->get([
  "handler" => "<some_handler>"
]);

// With dependencies
$values = $acrosureClient->getDataManager()->get([
  "handler" => "<some_handler>",
  "dependencies" => ["<dependency_1>", "<dependency_2>"]
]);
```

### Team

#### Get info

Get current team information.

```php
$teamInfo = $acrosureClient->getTeamManager()->getInfo();
```

### Other functionality

#### Verify webhook signature

Verify webhook signature by specify signature and raw data string. (Only Node.js environment)

```php
$isSignatureValid = $acrosureClient->verifySignature(
  "<signature>",
  "<raw_data>"
);
```

<!-- ## Advanced Usage -->

<!-- Please refer to [this document](https://acrosure.github.io/acrosure-php-sdk/AcrosureClient.html) for AcrosureClient usage. -->

<!-- And refer to [Acrosure API Document](https://docs.acrosure.com/docs/api-overall.html) for more details on Acrosure API. -->

## Associated Acrosure API endpoints

### Application

```
/applications/get
/applications/list
/applications/create
/applications/update
/applications/get-packages
/applications/get-package
/applications/select-package
/applications/submit
/applications/confirm
/applications/get-hash
```

### Product

```
/products/get
/products/list
```

### Policy

```
/policies/get
/policies/list
```

### Data

```
/data/get
```

### Team

```
/teams/get-info
```
