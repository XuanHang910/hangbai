<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\UserGroupMemberServiceInterface  as UserGroupMemberService;
use App\Repositories\Interfaces\UserGroupMemberRepositoryInterface  as UserGroupMemberRepository;
use App\Repositories\Interfaces\PermissionRepositoryInterface  as PermissionRepository;
use App\Http\Requests\StoreUserCatalogueRequest;

class UserGroupMemberController extends Controller
{
    protected $userGroupMemberService;
    protected $userGroupMemberRepository;
  //  protected $permissionRepository;

    public function __construct(
        UserGroupMemberService $userGroupMemberService,
        UserGroupMemberRepository $userGroupMemberRepository,
      //  PermissionRepository $permissionRepository
    ){
        $this->userGroupMemberService = $userGroupMemberService;
        $this->userGroupMemberRepository = $userGroupMemberRepository;
     //   $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request){
        $this->authorize('modules', 'user.groupmembers.index');
        $userGroupMember = $this->userGroupMemberService->paginate($request);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'UserGroupMember',
        ];
        $config['seo'] = config('apps.usergroupmembers');
        $template = 'backend.user.groupmembers.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'userGroupmember'
        ));
    }

    public function create(){
        $this->authorize('modules', 'user.groupmembers.create');
        $config['seo'] = config('apps.userGroupmember');
        $config['method'] = 'create';
        $template = 'backend.user.groupmembers.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    // public function store(StoreUserCatalogueRequest $request){
    //     if($this->userGroupMemberService->create($request)){
    //         return redirect()->route('user.groupmembers.index')->with('success','Thêm mới bản ghi thành công');
    //     }
    //     return redirect()->route('user.groupmembers.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    // }

    public function edit($id){
        $this->authorize('modules', 'user.groupmembers.update');
        $userGroupMember = $this->userGroupMemberRepository->findById($id);
        $config['seo'] = config('apps.userGroupMember');
        $config['method'] = 'edit';
        $template = 'backend.user.groupmembers.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'userGroupmember',
        ));
    }

    // public function update($id, StoreUserCatalogueRequest $request){
    //     if($this->userGroupMemberService->update($id, $request)){
    //         return redirect()->route('user.groupmembers.index')->with('success','Cập nhật bản ghi thành công');
    //     }
    //     return redirect()->route('user.groupmembers.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    // }

    public function delete($id){
        $this->authorize('modules', 'user.groupmembers.destroy');
        $config['seo'] = config('apps.groupmembers');
        $userGroupMember = $this->userGroupMemberRepository->findById($id);
        $template = 'backend.user.groupmembers.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'userGroupMember',
            'config',
        ));
    }

    public function destroy($id){
        if($this->userGroupMemberService->destroy($id)){
            return redirect()->route('user.groupmembers.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('user.groupmembers.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    public function permission(){
        $this->authorize('modules', 'user.groupmembers.permission');
        $userGroupMember = $this->userGroupMemberRepository->all(['permissions']);

        $permissions = $this->permissionRepository->all();
        $config['seo'] = __('messages.userGroupMember');
        $template = 'backend.user.groupmembers.permission';
        return view('backend.dashboard.layout', compact(
            'template',
            'userGroupMember',
            'permissions',
            'config',
        ));
    }

    public function updatePermission(Request $request){
        if($this->userGroupMemberService->setPermission($request)){
            return redirect()->route('user.groupmembers.index')->with('success','Cập nhật quyền thành công');
        }
        return redirect()->route('user.groupmembers.index')->with('error','Có vấn đề xảy ra, Hãy thử lại');
    }

}
