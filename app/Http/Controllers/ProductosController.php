<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        return view('productos');;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'codigo' => 'required|string|max:255|unique:productos',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'cantidad' => 'required|integer|min:0',
            'categorias' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $imagen = $request->file('imagen');

        if($imagen){
            $image_name = rand() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('images/logos_productos'), $image_name);
        }

        $producto = Producto::create([
            'codigo'=>$request->codigo,
            'nombre'=>strtoupper($request->nombre),
            'precio'=>$request->precio,
            'cantidad'=>$request->cantidad,
            'imagen'=>$image_name,
        ]);

        $categorias=explode(',',$request->categorias);
        $arrayCat=array();
        foreach($categorias as $cat){
            
            $categoria=Categoria::where('nombre_categoria',strtoupper($cat))->first();
            if($categoria){
                $arrayCat[]=$categoria->id;
            }else{
                $categoria = Categoria::create([
                    'nombre_categoria'=>strtoupper($cat)
                ]);
                $arrayCat[]=$categoria->id;
            }
        }
        $producto->categorias()->sync($arrayCat);

        ProductLog::create([
            'product_id' => $producto->id,
            'action' => 'created',
            'changes' => json_encode($producto->getAttributes()), 
            'user_id' => Auth::id() 
        ]);

        return $resultado = array('ErrorStatus'=>false,'Msj'=>'El producto se ha creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCantidad($cantidad,$id)
    {
        $producto = Producto::findOrFail($id);
        $producto->cantidad = $cantidad;
        $producto->save();

        $cambios = $producto->getChanges();

        if (!empty($cambios)) {
            ProductLog::create([
                'product_id' => $producto->id,
                'action' => 'updated',
                'changes' => json_encode($cambios), 
                'user_id' => Auth::id() 
            ]);
        }

        return $resultado = array('ErrorStatus'=>false,'Msj'=>'La cantidad se ha actualizado correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'cantidad' => 'required|integer|min:0',
            'categorias' => 'required|string',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $imagen = $request->file('imagen');

        $producto = Producto::findOrFail($id);

        //Guardar Imagen
        if($imagen){
            $image_name = rand() . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('images/logos_productos'), $image_name);
            if ($producto->imagen && file_exists(public_path('images/logos_productos' . $producto->imagen))) {
                unlink(public_path('images/logos_productos' . $producto->imagen));
            }
            $producto->imagen = $image_name;
        }
        
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->cantidad = $request->cantidad;
        $producto->save();

        //Guardar categorias
        $categorias=explode(',',$request->categorias);
        $arrayCat=array();
        foreach($categorias as $cat){
            
            $categoria=Categoria::where('nombre_categoria',strtoupper($cat))->first();
            if($categoria){
                $arrayCat[]=$categoria->id;
            }else{
                $categoria = Categoria::create([
                    'nombre_categoria'=>strtoupper($cat)
                ]);
                $arrayCat[]=$categoria->id;
            }
        }
        
        $producto->categorias()->sync($arrayCat);

        //Guardar Logs
        $cambios = $producto->getChanges();

        if (!empty($cambios)) {
            ProductLog::create([
                'product_id' => $producto->id,
                'action' => 'updated',
                'changes' => json_encode($cambios), 
                'user_id' => Auth::id() 
            ]);
        }

        return $resultado = array('ErrorStatus'=>false,'Msj'=>'El producto se ha actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Producto::destroy($id); // Eliminar directamente por id

        return $resultado = array('ErrorStatus'=>false,'Msj'=>'Se ha eliminado el producto');
    }

    public function deleteCat($idCategoria,$idProducto)
    {
        DB::table('categ_prod')->where([['producto_id',$idProducto],['categoria_id',$idCategoria]])->delete();
        return $resultado = array('ErrorStatus'=>false,'Msj'=>'Se ha eliminado la categoria del producto');
    }
}
