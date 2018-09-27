# EntityValidatorTrait

A simple Laravel trait for call Validation by your entities to allow data creating or updating.

## Installation

### With Composer

```
$ composer require moraesgil/entity-validator-trait
```

```json
{
   "require": {
      "moraesgil/entity-validator-trait": "~1.0"
   }
}
```
### Sample

```php
...

//Your Model
use Traits\Entities\EntityValidatorTrait;  //<<<<< add this line

class YourLaravelEntity extends Model {
   use EntityValidatorTrait;

   protected $table = 'samples';

   protected $rules = [ //<<<<< add this array with validation
      'id' => 'required|max:80|unique:samples,id,@except,id',
      'label' => 'required|max:80|unique:samples,label,@except,label',//<<<<< @except will be replaced by id value
   ];
}
```
Now you can call validate in your controller before store or update

```php
// Your  Controller
class SampleController extends Controller
{
   public function store(Request $request)
   {
      $model = new YourLaravelEntity();
      //here is the magic
      if ($model->hasRules()) { //<<<<< check has rules
         if (!$model->validate($request->all())) { //<<<<< validate
            return response()->json($model->errors, 400);
         }
      }
      return response()->json($model->create($request->all()), 201);
   }

   public function update(Request $request)
   {
      //here is the magic
      if ($model->hasRules()) { //<<<<< check has rules
         if (!$model->validate($request->all(), $id)) { //<<<<< validate
            return response()->json($model->errors, 400);
         }
      }
      return response()->json($model->update($request->all()), 201);
   }
}
```
## Authors

* **Gilberto Prudêncio Vaz de Moraes** - *Initial work* - [MoraesGil](https://github.com/Moraesgil)

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
