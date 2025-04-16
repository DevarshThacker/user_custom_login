<?php



namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

use App\Models\User;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class AuthController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index()

    {

        return view('auth.login');

    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function registration()

    {

        return view('auth.registration');

    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function postLogin(Request $request)

    {

        $request->validate([

            'email' => 'required',

            'password' => 'required',

        ]);



        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->intended('dashboard')

                        ->withSuccess('You have Successfully loggedin');

        }



        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');

    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function postRegistration(Request $request)

    {

        $request->validate([

            'name' => 'required',

            'email' => 'required|email|unique:users',

            'password' => 'required|min:6',

            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
            //  'image' => 'image',

        ]);


    //     $this->create($data);
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('images2'), $imageName);
    }
    // Create the user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
         'image' => $imageName, // Store the file name in the database;, // assumes your DB column is 'photo'

    ]);




        return redirect("login")->with('success1','account is successfully created!');

    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function dashboard()

    {

        if (Auth::check()) {
            $user = Auth::user(); // Get the logged-in user's data
            return view('dashboard', compact('user')); // Pass the user to the view
        }



        return redirect("login")->withSuccess('Opps! You do not have access');

    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    // public function create(array $data)

    // {
    //      dd($data);



    //   return User::create([

    //     'name' => $data['name'],

    //     'email' => $data['email'],

    //     'password' => Hash::make($data['password']),

    //     'image' => $data['image'], // Save the file path in the database

    //   ]);

    // }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function logout() {

        Session::flush();

        Auth::logout();



        return Redirect('login');

    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // $user = User::find($id);

        // // Validate inputs
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        //     'password' => 'nullable|string|min:6|confirmed',
        // ]);

        $user = User::find($id);
        // dd($request->all());
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images2'), $imageName);
        } else {
            $imageName = $user->image;
        }
        // $user->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password ? bcrypt($request->password) : $user->password,
        //     'image' => $imageName,
        // ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->image = $imageName; // Store the file name in the database;, // assumes your DB column is 'photo'


        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('dashboard', ['id' => $id])->with('success', 'User updated successfully.');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('login')->with('success', 'User deleted successfully.');
        }
        return redirect('dashboard')->with('error', 'User not found.');
    }
}
