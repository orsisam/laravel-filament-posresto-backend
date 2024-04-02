<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryObserver
{
    public function saved(Category $category)
    {
        if ($category->isDirty('image')) {
            if (!is_null($category->getOriginal('image'))) {
                Storage::disk('public')->delete($category->getOriginal('image'));
            }
        }
    }

    public function deleted(Category $category)
    {
        if (!is_null($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
    }
}
