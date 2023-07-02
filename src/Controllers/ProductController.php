<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Storage;
use App\Models\Product;
use App\Validation\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $sort = $this->request->input('sort') ?? 'id';
        $dir = $this->request->input('dir') ?? 'asc';

        $products = (new Product())->orderBy($sort, $dir)->paginate(5)->get();
        return $this->view->render('products/index', [
            'products' => $products['data'],
            'pagination' => $products['pagination'],
            'sort' => $sort,
            'dir' => $dir
        ]);
    }

    public function create()
    {
        return $this->view->render('products/create');
    }

    public function store()
    {
        $data = $this->request->body();
        $data['image'] = $this->request->file('image');
        $validator = new Validator($data);

        $validator->validate([
            'title' => 'required|string|max:55',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|file|image:jpg,png,jpeg|max:2048'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInputs($data);
        }

        $imageUrl = (new Storage())->store($data['image'], 'images');


        (new Product())->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $imageUrl
        ]);

        return redirect()->to(url('/products'))->with('success', "The {$data['title']} has ben created successfully");
    }

    public function edit($id)
    {
        $product = (new Product())->findById($id);
        return $this->view->render('products/edit', ['product' => $product]);
    }

    public function update($id)
    {
        $data = $this->request->body();

        if ($this->request->hasFile('image')) {
            $data['image'] = $this->request->file('image');
            $validator = new Validator($data);

            $validator->validate([
                'title' => 'required|string|max:55',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'image' => 'required|file|image:jpg,png,jpeg|max:2048'
            ]);
        } else {
            $validator = new Validator($data);

            $validator->validate([
                'title' => 'required|string|max:55',
                'description' => 'required|string',
                'price' => 'required|numeric',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInputs($data);
        }

        $product = (new Product())->findById($id);

        if ($product) {
            if ($this->request->hasFile('image')) {
                $imageUrl = (new Storage())->store($data['image'], 'images');
            } else {
                $imageUrl = $product->image;
            }

            $product->update($id, [
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'image' => $imageUrl
            ]);
            return redirect()->to(url('/products'))->with('success', "The {$data['title']} has ben updated successfully");
        }

        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }


    public function delete($id)
    {
        $product = (new Product())->findById($id);

        if ($product->delete($id)) {
            return redirect()->back()->with('success', "The {$product->title} has ben deleted successfully");
        }
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}
