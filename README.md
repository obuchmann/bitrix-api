# Bitrix Api
PHP library to access Bitrix24 via incomming webhoook API

## Usage

```php

use Obuchmann\BitrixApi\BitrixApi;

class YourClass {
    public function __construct(
        private BitrixApi $api,        
    )
    {}
    
    public function getCompanies(){
        return $this->api->request('crm.company.list')->select([            
            "TITLE",
        ])->all();
    }  
}
```