<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Post;
use App\Models\PostImage;
use App\Traits\UploadFile;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
{
    use UploadFile;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitCreate;
    }

    public function setup()
    {
        $this->crud->setModel('App\Models\Post');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/post');
        $this->crud->setEntityNameStrings('post', 'posts');
    }

    //---------------------------------------------------------------------------
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'title',
            'label' => 'Title'
        ]);

        $this->crud->addColumn([
            'name' => 'img',
            'label' => 'Image',
            'type' => 'image',
            'disc' => 'public',
            'prefix' => 'storage/posts/',
            'height' => '80px',
            'width'  => '80px',
        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupShowOperation()
    {
        CRUD::setColumns([
            [
                'name' => 'title',
                'label' => 'العنوان',
                'type' => 'text',
            ],
            [
                'name' => 'content',
                'label' => 'النص',
                'type' => 'textarea',
                'value' => function($entry) {
                    return $entry->content;
                },
                'raw' => true,
            ],
            [
                'name' => 'img',
                'label' => 'الصورة الرئيسية',
                'type' => 'image',
                'disc' => 'public',
                'prefix' => 'storage/posts/',
                'height' => '500px',
                'width'  => '500px',
            ],
            [
                'name' => 'images',
                'label' => 'ألبوم الصور',
                'type' => 'model_function',
                'function_name' => 'getImagesAlbum',
                'raw' => true,
            ]
        ]);
    }

    //---------------------------------------------------------------------------
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PostRequest::class);

        CRUD::field('title');

        $this->crud->addField([
            'name'  => 'content',
            'label' => 'Content',
            'type'  => 'summernote',
            'options' => [
                'toolbar' => [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['GE SS Two Light', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            ],
        ]);

        CRUD::field('img')
            ->type('upload')
            ->label('Main Image')
            ->upload('public/posts') // Store in storage/app/public/posts
            ->withFiles([
                'disk' => 'public',
                'path' => 'posts',
            ])
            ->attributes([
                'accept' => 'image/*',
            ]);

        CRUD::field('images')
            ->type('upload_multiple')
            ->label('Album Images')
            ->upload('public/posts')
            ->withFiles([
                'disk' => 'public',
                'path' => 'posts',
            ])
            ->attributes([
                'accept' => 'image/*',
            ]);
    }

    //---------------------------------------------------------------------------
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        CRUD::field('img')
            ->type('image')
            ->label('Main Image')
            ->disk('public')
            ->prefix('posts/');
    }

    //---------------------------------------------------------------------------
    public function store(PostRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $coverImage = $request->hasFile('img') ? $this->uploadFile('posts/', $request->file('img')) : null;

            $post = Post::create([
                'title'   => $request->title,
                'content' => $request->content,
                'img'     => $coverImage,
            ]);

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $this->uploadFile('posts/', $image);

                    PostImage::create([
                        'post_id' => $post->id,
                        'img'   => $path,
                    ]);
                }
            }

            DB::commit();
            \Alert::success('Post created successfully')->flash();
            return redirect()->route('post.index');
        } catch (Exception $e) {
            report($e);
            DB::rollBack();
        }
    }

    //-------------------------------------------
    public function update(PostRequest $request)
    {
        // dump($request->all());
        DB::beginTransaction();
        try {
            // الحصول على البيانات القديمة
            $post = $this->crud->getEntry($request->get('id'));
            $coverImage = '';

            // رفع صورة اساسية جديدة
            // $coverImage = $request->hasFile('img') ? $this->uploadFile('posts/', $request->file('img')) :  basename(parse_url($request->img, PHP_URL_PATH));
            if(preg_match('/^data:image\/(\w+);base64,/', $request->img))
            {
                Storage::disk('public')->delete('posts/'.$post->img);
                $coverImage = $this->uploadFile('posts/', $request->img);
            }
            else{
                $coverImage = basename($request->img);
            }

            // التعامل مع الصور الجديدة
            if ($request->has('images')) {
                $newImages = $request->hasFile('images')
                ? array_filter($request->file('images'), fn($file) => $file instanceof UploadedFile)
                : [];

                if (count($newImages) > 0) {
                    // قم بتحميل الصور الجديدة هنا وحفظها في المسار المطلوب
                    foreach ($newImages as $image) {
                        $path = $this->uploadFile('posts/', $image);

                        PostImage::create([
                            'post_id' => $post->id,
                            'img'   => $path,
                        ]);
                    }
                }
            }

            // التعامل مع الصور المحذوفة
            if ($request->has('clear_images')) {
                $clearImages = $request->input('clear_images');
                foreach ($clearImages as $imagePath) {
                    $imageToDelete = $post->images()->where('img', basename($imagePath))->first();
                    if ($imageToDelete) {
                        // حذف الصورة من التخزين
                        Storage::disk('public')->delete($imagePath);
                        // حذف السجل من قاعدة البيانات
                        $imageToDelete->delete();
                    }
                }
            }

            // تحديث باقي البيانات في النموذج
            $post->update([
                'title'   => $request->title,
                'content' => $request->content,
                'img'     =>$coverImage,
            ]);

            DB::commit();
            \Alert::success('Post updated successfully')->flash();
            return redirect()->route('post.index');
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            \Alert::error('Error updating the post')->flash();
            return back();
        }
    }

    //------------------------------------------------------------
    public function destroy($id)
    {
        $post = $this->crud->getEntry($id);

        // حذف الصور من التخزين
        if ($post->img) {
            Storage::disk('public')->delete('posts/' . $post->img);
        }

        if($post->images){
            foreach($post->images as $image){
                Storage::disk('public')->delete('posts/' . $image->img);
            }
        }

        // استدعاء الدالة الأصلية للحذف من قاعدة البيانات
        $this->crud->delete($id);
        return redirect()->route('post.index');
    }
}
