<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CommentUtils extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getListCommentByUser($user_id){
        $listComment = DB::table('binhluan')->where('user_id', $user_id)->get();
        $html = '<table class="table">';
        foreach ($listComment as $row){

        }
    }

    public static function getHTMLComment($phim_id, $limit, $offset){
        $listComment = DB::select(DB::raw('SELECT users.name, users.email, users.avatar, users.active, users.locked_at, binhluan.*, (SELECT count(1) FROM users_roles WHERE users_roles.user_id = binhluan.user_id) AS role FROM users, binhluan WHERE binhluan.user_id = users.id AND binhluan.phim_id ='.$phim_id.' AND binhluan_id_cha = 0 ORDER BY binhluan_id DESC LIMIT '.$limit.' OFFSET '.$offset));
        $isAdmin = false;        
        $hasLogin = Auth::check();
        if($hasLogin && (count(explode(RoleUtils::getRoleSuperAdmin(),Auth::user()->getRoles())) > 1 || count(explode(RoleUtils::getRoleAdminUser(),Auth::user()->getRoles())) > 1)){
            $isAdmin = true;
        }        
        $html = "";
        if(count($listComment)>0){
            foreach ($listComment as $row){
                $subComment = DB::select(DB::raw('SELECT users.name, users.email, users.avatar, users.active, users.locked_at, binhluan.*, (SELECT count(1) FROM users_roles WHERE users_roles.user_id = binhluan.user_id) AS role FROM users, binhluan WHERE binhluan.user_id = users.id AND binhluan.phim_id ='.$phim_id.' AND binhluan_id_cha = '.$row->binhluan_id.' ORDER BY binhluan_id DESC'));
                $subHTML = '';
                $html   .= '<tr><td style="width:60px; height:60px;vertical-align:top; '.($isAdmin&&strcmp(Auth::user()->email, $row->email)!=0?'cursor:pointer;':'').'" '.($isAdmin&&strcmp(Auth::user()->email, $row->email)!=0&&$row->active==1?'oncontextmenu="openContextMenu('.$row->binhluan_id.')"':'').'>';
                if($row->active == 1){
                    $html   .=      '<img src="'.URL('/').'/'.$row->avatar.'" class="avatar img-circle '.$row->binhluan_id.'" width="60" height="60" />';
                    $html   .=      '</td><td class="text-left">'; 
                    $html   .=      '<div><span class="username-comment '.$row->binhluan_id.($row->role>0?' color-name-admin':'').'" style="font-weight: 700;">'.($isAdmin?$row->name.' ('.$row->email.')':$row->name).'</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($row->binhluan_ngaycapnhat).'</span></div>';
                    $html   .=      '<div><span class="content-comment '.$row->binhluan_id.($row->role>0?' color-comment-admin':'').'">'.$row->binhluan_noidung.'</span>';
                    if($hasLogin){
                        $html   .=      '<span class="icon-reply-'.$row->binhluan_id.'" style="float:right;" onclick="openReply('.$row->binhluan_id.');"><a href="javascript:void(0);">Trả lời</a></span>';
                    }
                    $html   .=      '</div>';
                    $reply   =      '<div class="reply-'.$row->binhluan_id.' input-group" style="display:none">';
                    $reply  .=      '<textarea class="input-reply form-control" rows="2"></textarea>';
                    $reply  .=      '<span class="input-group-addon btn btn-primary" style="color:#fff; background-color: #337ab7;" onclick="replyComment('.$row->binhluan_id.')" >Trả lời</span>';
                    $reply  .=      '<span class="btn input-group-addon" onclick="cancelReply('.$row->binhluan_id.');">Hủy</span>';
                    $reply  .=      '</div>';
                    $html   .= $reply;
                    if(count($subComment)>0){
                        $subHTML = '<table class="table">';
                        foreach($subComment as $sub){                            
                            $subHTML   .= '<tr><td style="width:60px; height:60px; '.($isAdmin&&strcmp(Auth::user()->email, $sub->email)!=0?'cursor:pointer;':'').'" '.($isAdmin&&strcmp(Auth::user()->email, $sub->email)!=0&&$row->active==1?'oncontextmenu="openContextMenu('.$sub->binhluan_id.')"':'').'>';
                            if($sub->active == 1){
                                $subHTML   .=      '<img src="'.URL('/').'/'.$sub->avatar.'" class="avatar img-circle '.$sub->binhluan_id.'" width="100%"/>';
                                $subHTML   .=      '</td><td class="text-left">';                                        
                                $subHTML   .=      '<div><span class="username-comment '.$sub->binhluan_id.($sub->role>0?' color-name-admin':'').'" style="font-weight: 700;">'.($isAdmin?$sub->name.' ('.$sub->email.')':$sub->name).'</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($sub->binhluan_ngaycapnhat).'</span></div>';
                                $subHTML   .=      '<div class="content-comment '.$sub->binhluan_id.($sub->role>0?' color-comment-admin':'').'">'.$sub->binhluan_noidung.'</div>';
                                $subHTML   .= '</td></tr>';   
                            }   else {
                                $subHTML   .=      '<img src="'.asset('/public/img/themes/avatar/user-locked.png').'" class="avatar img-circle" width="60" height="60" />';
                                $subHTML   .=      '</td><td class="text-left">'; 
                                $subHTML   .=      '<div><span class="username-comment color-name-locked" style="font-weight: 700;">Tài khoản bị khóa</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($sub->locked_at).'</span></div>';
                                $subHTML   .=      '<div class="content-comment color-comment-locked">Nội dung không được phép hiển thị</div>';
                            }
                        }
                        $subHTML .= '</table>';
                    }
                    $html   .= $subHTML;
                } else {
                    $html   .=      '<img src="'.asset('/public/img/themes/avatar/user-locked.png').'" class="avatar img-circle" width="60" height="60" />';
                    $html   .=      '</td><td class="text-left">'; 
                    $html   .=      '<div><span class="username-comment color-name-locked" style="font-weight: 700;">Tài khoản bị khóa</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($row->locked_at).'</span></div>';
                    $html   .=      '<div class="content-comment color-comment-locked">Nội dung không được phép hiển thị</div>';
                }                                                                                   
                $html   .= '</td></tr>';            
            }
            return $html;
        }else {
            return '<tr><td colspan="2" class="text-center"><i style="color:gray">Không tìm thấy dữ liệu</i></td></tr>';
        }        
    }
}