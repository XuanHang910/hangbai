<?php

namespace App\Services;

use App\Services\Interfaces\UserGroupMemberServiceInterface;
use App\Repositories\Interfaces\UserGroupMemberRepositoryInterface as UserGroupMemberRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserCatalogueService
 * @package App\Services
 */
class UserGroupMemberService extends BaseService implements UserGroupMemberServiceInterface
{
    protected $userGroupMemberRepository;
    protected $userRepository;
    

    public function __construct(
        UserGroupMemberRepository $userGroupMemberRepository,
        UserRepository $userRepository
    ){
        $this->userGroupMemberRepository = $userGroupMemberRepository;
        $this->userRepository = $userRepository;
    }

    

    public function paginate($request){
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish')
        ];
        $perPage = $request->integer('perpage');
        $userGroupMember = $this->userGroupMemberRepository->pagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage, 
            ['path' => 'user/groupmember/index'], 
            ['id', 'DESC'],  
            [],
            ['users']
        );
        return $userGroupMember;
    }

    public function create($request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $user = $this->userGroupMemberRepository->create($payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }


    public function update($id, $request){
        DB::beginTransaction();
        try{

            $payload = $request->except(['_token','send']);
            $user = $this->userGroupMemberRepository->update($id, $payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $user = $this->userGroupMemberRepository->delete($id);

            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }


    private function changeUserStatus($post, $value){
        DB::beginTransaction();
        try{
            $array = [];
            if(isset($post['modelId'])){
                $array[] = $post['modelId'];
            }else{
                $array = $post['id'];
            }
            $payload[$post['field']] = $value;
            $this->userRepository->updateByWhereIn('user_catalogue_id', $array, $payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function setPermission($request){
        DB::beginTransaction();
        try{
           
            $permissions = $request->input('permission');
            if(count($permissions)){
                foreach($permissions as $key => $val){
                    $userGroupMember = $this->userGroupMemberRepository->findById($key);
                    $userGroupMember->permissions()->detach();
                    $userGroupMember->permissions()->sync($val);
                   
                }
            }
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
        //Mục đích là đưa được dữ liệu vào bên trong bảng user_catalogue_permission
    }


    private function paginateSelect(){
        return [
            'id', 
            'name', 
            'description',
            'publish',

        ];
    }


}
