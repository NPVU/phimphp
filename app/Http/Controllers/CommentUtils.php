<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CommentUtils extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function comment(Request $request){
        if(strcmp(Session::token(), $request->token) == 0){
            if (Auth::check()) {
                $user = Auth::user();                
                DB::table('binhluan')->insert([
                    'binhluan_noidung' => $request->content,
                    'phim_id' => $request->pid,
                    'user_id' => $user->id,
                    'binhluan_ngaycapnhat' => now()
                ]);
                return CommentUtils::getHTMLComment($request->pid, Session::get('CommentPerPage'), 0);
            } else {
                return -1;
            }               
        } else {
            return 0;
        }
    }

    public function replyComment(Request $request){
        if (Auth::check()) {
            $user = Auth::user();      
            $binhluan = DB::table('binhluan')->where('binhluan_id', $request->cid)->get();          
            DB::table('binhluan')->insert([
                'binhluan_noidung' => $request->content,
                'phim_id' => $binhluan[0]->phim_id,
                'user_id' => $user->id,
                'binhluan_id_cha' => $request->cid,
                'binhluan_ngaycapnhat' => now()
            ]);
            $commentPerPage = Session::get('CommentPerPage') * ($request->page - 1);
            return CommentUtils::getHTMLComment($binhluan[0]->phim_id, $commentPerPage, 0);
        } else {
            return -1;
        }
    }

    public function deleteComment(Request $request){
        if($this->hasRole()){
            if($request->cid != 0){
                DB::table('binhluan')->where('binhluan_id_cha', $request->cid)->delete();
                DB::table('binhluan')->where('binhluan_id', $request->cid)->delete();
                DB::table('binhluan_report')->where('binhluan_id', $request->cid)->delete();
            }
        }
    }

    public function xemThemComment(){
        $comment_per_page = Session::get('CommentPerPage');
        if(Input::get('page') != null){
            $page  = Input::get('page')==0?1:Input::get('page');
            $offset = ($page-1) * $comment_per_page;            
            $comment = CommentUtils::getHTMLComment(Input::get('pid'),$comment_per_page,$offset);
        } else {
            $comment = CommentUtils::getHTMLComment(Input::get('pid'),$comment_per_page,0);
        }   
        return $comment;
    }

    public function reportComment(Request $request){           

        DB::table('binhluan_report')->insert([
            'binhluan_id' => $request->cid,
            'cr_content' => $request->content,           
            'cr_ngaycapnhat' => now()
        ]);
        
        return 'Chúng tôi đã nhận được report của bạn. Cảm ơn bạn đã ủng hộ website.';        
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
                $html   .= '<tr><td style="width:60px; height:60px;vertical-align:top; '.($isAdmin&&strcmp(Auth::user()->email, $row->email)!=0?'cursor:pointer;':'').'" '.($isAdmin&&strcmp(Auth::user()->email, $row->email)!=0&&$row->active==1?'onclick="openContextMenu('.$row->binhluan_id.')"':'').'>';
                if($row->active == 1){
                    $html   .=      '<img src="'.URL('/').'/'.$row->avatar.'" class="avatar img-circle '.$row->binhluan_id.'" width="60" height="60" />';
                    $html   .=      '</td><td class="text-left">'; 
                    $html   .=      '<div><span class="username-comment '.$row->binhluan_id.($row->role>0?' color-name-admin':'').'" style="font-weight: 700;">'.($isAdmin?$row->name.' ('.$row->email.')':$row->name).'</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($row->binhluan_ngaycapnhat).'</span></div>';
                    $html   .=      '<div><span class="content-comment '.$row->binhluan_id.($row->role>0?' color-comment-admin':'').'">'.$row->binhluan_noidung.'</span>';
                    if($hasLogin){
                        $html   .=      '<span class="icon-reply-'.$row->binhluan_id.'" style="float:right;" onclick="openReply('.$row->binhluan_id.');"><a href="javascript:void(0);">Trả lời</a></span>';
                    }
                    $html   .=      '</div>';
                    $html   .=      '<div><a href="javascript:void(0);" title="Report" onclick="openReport('.$row->binhluan_id.')"><span class="fa fa-exclamation-triangle" style="color:red"></span></a></div>';                                       
                    $reply   =      '<div class="reply-'.$row->binhluan_id.' input-group" style="display:none">';
                    $reply  .=      '<textarea class="input-reply form-control" rows="2"></textarea>';
                    $reply  .=      '<span class="input-group-addon btn btn-primary" style="color:#fff; background-color: #337ab7;" onclick="replyComment('.$row->binhluan_id.')" >Trả lời</span>';
                    $reply  .=      '<span class="btn input-group-addon" onclick="cancelReply('.$row->binhluan_id.');">Hủy</span>';
                    $reply  .=      '</div>';
                    $html   .= $reply;
                    if(count($subComment)>0){
                        $subHTML = '<table class="table">';
                        foreach($subComment as $sub){                            
                            $subHTML   .= '<tr><td style="width:60px; height:60px; '.($isAdmin&&strcmp(Auth::user()->email, $sub->email)!=0?'cursor:pointer;':'').'" '.($isAdmin&&strcmp(Auth::user()->email, $sub->email)!=0&&$row->active==1?'onclick="openContextMenu('.$sub->binhluan_id.')"':'').'>';
                            if($sub->active == 1){
                                $subHTML   .=      '<img src="'.URL('/').'/'.$sub->avatar.'" class="avatar img-circle '.$sub->binhluan_id.'" width="100%"/>';
                                $subHTML   .=      '</td><td class="text-left">';                                        
                                $subHTML   .=      '<div><span class="username-comment '.$sub->binhluan_id.($sub->role>0?' color-name-admin':'').'" style="font-weight: 700;">'.($isAdmin?$sub->name.' ('.$sub->email.')':$sub->name).'</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($sub->binhluan_ngaycapnhat).'</span></div>';
                                $subHTML   .=      '<div class="content-comment '.$sub->binhluan_id.($sub->role>0?' color-comment-admin':'').'">'.$sub->binhluan_noidung.'</div>';
                                $subHTML   .=      '<div><a href="javascript:void(0);" title="Report" onclick="openReport('.$sub->binhluan_id.')"><span class="fa fa-exclamation-triangle" style="color:red"></span></a></div>';                                       
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
    public static function getHTMLComments($phim_id){
        $listComment = DB::select(DB::raw('SELECT users.name, users.email, users.avatar, users.active, users.locked_at, binhluan.*, (SELECT count(1) FROM users_roles WHERE users_roles.user_id = binhluan.user_id) AS role FROM users, binhluan WHERE binhluan.user_id = users.id AND binhluan.phim_id ='.$phim_id.' AND binhluan_id_cha = 0 ORDER BY binhluan_id DESC'));             
        $hasLogin = Auth::check();               
        $html = "";
        if(count($listComment)>0){
            foreach ($listComment as $row){
                $subComment = DB::select(DB::raw('SELECT users.name, users.email, users.avatar, users.active, users.locked_at, binhluan.*, (SELECT count(1) FROM users_roles WHERE users_roles.user_id = binhluan.user_id) AS role FROM users, binhluan WHERE binhluan.user_id = users.id AND binhluan.phim_id ='.$phim_id.' AND binhluan_id_cha = '.$row->binhluan_id.' ORDER BY binhluan_id DESC'));
                $subHTML = '';
                $html   .= '<tr><td style="width:60px; height:60px;vertical-align:top;">';
                if($row->active == 1){
                    $html   .=      '<img src="'.URL('/').'/'.$row->avatar.'" class="avatar img-circle '.$row->binhluan_id.'" width="60" height="60" />';
                    $html   .=      '</td><td class="text-left">'; 
                    $html   .=      '<div><span class="username-comment" style="font-weight: 700;">'.$row->name.' ('.$row->email.')'.'</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($row->binhluan_ngaycapnhat).'</span></div>';
                    $html   .=      '<div><span class="content-comment">'.$row->binhluan_noidung.'</span>';
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
                            $subHTML   .= '<tr><td style="width:60px; height:60px;">';
                            if($sub->active == 1){
                                $subHTML   .=      '<img src="'.URL('/').'/'.$sub->avatar.'" class="avatar img-circle '.$sub->binhluan_id.'" width="100%"/>';
                                $subHTML   .=      '</td><td class="text-left">';                                        
                                $subHTML   .=      '<div><span class="username-comment" style="font-weight: 700;">'.$sub->name.' ('.$sub->email.')'.'</span><span style="float:right;">'.ClassCommon::getStrSoNgayDaQua($sub->binhluan_ngaycapnhat).'</span></div>';
                                $subHTML   .=      '<div class="content-comment ">'.$sub->binhluan_noidung.'</div>';                                
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