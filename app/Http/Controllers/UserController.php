<?php

namespace App\Http\Controllers;

use App\Actions\UserActions;
use Illuminate\Http\Request;
use App\Models\User;

use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Get(path: '/api/v1/admin/users', description: 'Return List of Users', summary: 'List of Users', tags: ['Admin'])]
    #[OA\Response(response: 200, description: 'Users', content: new OA\JsonContent(ref: '#/components/schemas/UserCollection'))]
    #[OA\Response(ref: '#/components/responses/401', response: 401)]
    #[OA\Response(ref: '#/components/responses/403', response: 403)]
    #[OA\Response(ref: '#/components/responses/404', response: 404)]
    public function index(Request $request)
    {
        return UserActions::listUsers($request);
    }

    public function userDashboard(Request $request)
    {
        $users = UserActions::listUsers($request);;
        $isAdmin = UserActions::isAdmin();
 
        return view('usuario.dashboard', compact('users', 'isAdmin'));
    }


    public function create()
    {
        return view('usuario.dashboardCreate');
    }

    public function save(Request $request)
    {
        try {
            $users = new User;
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = bcrypt($request->password);
            $users->save();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'Email já está em uso.');
            }
            throw $e; 
        }

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully!');
    }


    public function delete($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('usuario.dashboardEdit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        $user->update($data);

        return redirect()->route('admin.dashboard', $user->id);
    }
}
