<?php

namespace App\Http\Controllers;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Response;
use App\User;
use Flash;
use Auth;

class UserController extends AppBaseController
{

    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepo;
    }


    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->all();

        return view('users.index')
            ->with('users', $users);
    }


    public function create()
    {
        return view('users.create');
    }


    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        Flash::success('User saved successfully.');

        return redirect(route('users.index'));
    }


    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    public function profile($id)

    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user) || $user->id != Auth::user()->id) {

            return redirect(route('dash'));
        }

        return view('users.show')->with('user', $user);
    }


    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }


    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('User updated successfully.');

        return redirect(route('users.index'));
    }


    public function destroy($id)
    {
      $user = $this->userRepository->findWithoutFail($id);

        if (isset($user->avatar)) {
          Storage::delete('public/user_images/' . $user->avatar);
        }

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        User::destroy($id);

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }
}
