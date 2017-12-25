<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
    	return view('admin.products.index')->with(compact('products')); // listado
    }
    public function create()
    {
    	return view('admin.products.create');  // formulario de registro
    }
    public function store(Request $request)
    {
        // Validar
        $messages =[
            'name.required' => 'Es necesario ingresar un nombre para el producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta solo admite hasta 200 carcteres.',
            'price.required' => 'Es obligatorio definir un precio para el producto.',
            'price.numeric' => 'Ingresar un precio valido.',
            'price.min' => 'No se admiten valores negativos.'
        ];
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'
        ];
        $this->validate($request, $rules, $messages);
    	// registrar nuevo producto en la BD
        // dd($request->all());
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->long_description = $request->input('long_description');
        $product->save();  // Insert

        return redirect('/admin/products');

    }
    public function edit($id)
    {
        // return "Mostrar aqui el form de edicion para el producto con id $id";
        $product = Product::find($id);
        return view('admin.products.edit')->with(compact('product'));  // formulario de registro
    }
    
    public function update(Request $request, $id)

    {
        // Validar
        $messages =[
            'name.required' => 'Es necesario ingresar un nombre para el producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta solo admite hasta 200 carcteres.',
            'price.required' => 'Es obligatorio definir un precio para el producto.',
            'price.numeric' => 'Ingresar un precio valido.',
            'price.min' => 'No se admiten valores negativos.'
        ];
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'
        ];
        $this->validate($request, $rules, $messages);
        // registrar nuevo producto en la BD
        // dd($request->all());
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->long_description = $request->input('long_description');
        $product->save();  // Update

        return redirect('/admin/products');

    }
    public function destroy($id)
    {
        
        $product = Product::find($id);
        
        $product->delete();  // Delete

        return back();

    }
}
