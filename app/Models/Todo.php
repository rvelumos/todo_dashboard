<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];    

    public function childTodos() { 
        return $this->hasMany( 'App\Models\Todo', 'parent_id'); 
    } 

    public static function getParentList() {

        $parent_rows = Todo::whereNull('parent_id')->count();

        if($parent_rows > 0) {
            $parents = Todo::whereNull('parent_id')->orderByDesc('title')->get();
            echo "<select name='parent_id'>";
            echo "<option></option>";
            foreach($parents as $parent) {                 
                echo "<option value='{$parent->id}'>{$parent->title}</option>";                
            }
            echo "</select>";
        }
    }
    

}
