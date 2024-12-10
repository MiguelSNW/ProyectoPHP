<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareasCtrl;
use App\Http\Controllers\AuthCtrl;
use App\Http\Controllers\UserCtrl;
use App\Http\Controllers\AdminCtrl;

//Rutas Sesiones
Route::any('/', [AuthCtrl::class, 'PanelLog']);
Route::get('/login', [AuthCtrl::class, 'showLoginForm'])->name('login');
Route::post('/dashboard', [AuthCtrl::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthCtrl::class, 'logout'])->name('logout');

//Rutas Operario
Route::get('/operario/dashboard', [UserCtrl::class, 'index'])->name('operario.dashboard');
Route::any('/operario/ListaTareasUser', [TareasCtrl::class, 'ListaTareasUser']);
Route::get('/operario/ListaTareasUser/{pagina?}', [TareasCtrl::class, 'ListaTareasUser'])->name('lista_tareasuser');
Route::get('/operario/Inicio', [UserCtrl::class, 'index'])->name('operario.dashboard');
Route::get('/operario/TareasPendientes', [TareasCtrl::class, 'ListaTareasPendientes'])->name('tareas.pendientes');
Route::get('/operario/TareasPendientes/{id}', [TareasCtrl::class, 'FormularioAprobarTareas'])->name('tareas.confirmar');
Route::put('/operario/AprobarTarea/{id}',[TareasCtrl::class,'aprobarTarea'])->name('tareas.aprobar');

//Rutas Administrador
Route::get('/dashboard', [AdminCtrl::class, 'Inicio'])->name('admin.dashboard');
Route::get('/admin/dashboard', [AdminCtrl::class, 'Inicio'])->name('admin.dashboard');
Route::get('/admin/ListaTareas/{pagina?}', [TareasCtrl::class, 'ListaTareasAdmin'])->name('lista_tareas');
Route::delete('/admin/EliminarTareas/{id}', [TareasCtrl::class, 'eliminar'])->name('tareas.eliminar');
Route::get('/admin/EliminarTareas/{pagina?}', [TareasCtrl::class, 'VistaTareas'])->name('tareas.listael');
Route::get('/admin/ModificarTareas{pagina?}', [TareasCtrl::class, 'ModificarTareas'])->name('listamod');
Route::get('/admin/ModificarTarea/{id}', [TareasCtrl::class, 'mostrarFormularioModificar'])->name('tareas.modificar');
Route::put('/admin/ActualizarTarea/{id}', [TareasCtrl::class, 'actualizarTarea'])->name('tareas.actualizar');
Route::any('/admin/InsertarTareas', [TareasCtrl::class, 'Insertar']);
Route::post('/admin/InsertarTarea', [TareasCtrl::class, 'insertarTarea'])->name('tareas.insertar');
Route::any('/admin/VistaUsuarios/{pagina?}', [TareasCtrl::class, 'VistaUsuarios'])->name('vistauser');
Route::delete('/admin/EliminarUser/{usuario}', [TareasCtrl::class, 'eliminarUsuario'])->name('tareas.eliminaruser');
Route::any('/admin/InsertarUser',[TareasCtrl::class, 'mostrarFormularioInsertar'])->name('tareas.insertaruser');
Route::any('/admin/Insertar',[TareasCtrl::class, 'insertarUser'])->name('insertaruser');
Route::any('/admin/ModificarClave/{usuario}', [TareasCtrl::class, 'mostrarFormularioClave'])->name('modificaruser');
Route::any('/admin/ModificarTipo/{usuario}',[TareasCtrl::class, 'mostrarFormularioTipo'])->name('modificartipo');
Route::any('/admin/ActualizarClave/{usuario}',[TareasCtrl::class, 'actualizarClave'])->name('actualizarclave');

//Rutas de Prueba



/**
 * Devuelve el valor de una variable enviada por POST. Devolverá el valor
 * por defecto en caso de no existir.
 *
 * @param string $campo
 * @param string $default   Valor por defecto en caso de no existir
 * @return string
 */
function VPost($campo, $default='')
{
    if (isset($_POST[$campo]))
    {
        return $_POST[$campo];
    }
    else
    {
        return $default;
    }
}


