<?php
require_once __DIR__ . '/../config.php';
function formatBlog($row){
$catColors=[
'Cardiology Care'=>'bg-red-100 text-red-700',
'Cardiology'=>'bg-red-100 text-red-700',
'Diabetology'=>'bg-emerald-100 text-emerald-700',
'Gastrointestinal (Gastric) Care'=>'bg-amber-100 text-amber-700',
'Gastroenterology'=>'bg-amber-100 text-amber-700',
'Thyroid Management'=>'bg-violet-100 text-violet-700',
'General Health'=>'bg-sky-100 text-sky-700',
'Wellness'=>'bg-teal-100 text-teal-700'
];
$cat=$row['category']?:'General Health';
return [
'id'=>$row['id'],
'slug'=>$row['slug'],
'cat'=>$cat,
'cat_color'=>$catColors[$cat]??'bg-sky-100 text-sky-700',
'img'=>$row['featured_image']?:'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=1200&auto=format&fit=crop',
'title'=>$row['title'],
'excerpt'=>$row['short_description']?:substr(strip_tags($row['content']),0,120),
'date'=>date('M d, Y',strtotime($row['created_at'])),
'timestamp'=>strtotime($row['created_at']),
'read'=>'5 min read',
'badge'=>$row['status']==='published'?'Live':'Draft',
'author'=>'Dr. Manisha Gupta',
'author_img'=>'images/profile pic/manisha.png',
'tags'=>[],
'content'=>$row['content']
];}
function getAllBlogs(): array{global $db;$res=$db->query("SELECT * FROM blogs WHERE status='published' ORDER BY created_at DESC");$data=[];while($r=$res->fetch_assoc()){$data[]=formatBlog($r);}return $data;}
function getBlogBySlug(string $slug): ?array{global $db;$stmt=$db->prepare("SELECT * FROM blogs WHERE slug=? LIMIT 1");$stmt->bind_param("s",$slug);$stmt->execute();$r=$stmt->get_result()->fetch_assoc();return $r?formatBlog($r):null;}
function getFeaturedBlogs(int $limit=3): array{return array_slice(getAllBlogs(),0,$limit);} 
function getBlogsByCategory(string $cat): array{return array_values(array_filter(getAllBlogs(),fn($b)=>$b['cat']===$cat));}
function getCategoryList(): array{$blogs=getAllBlogs();$counts=[];foreach($blogs as $b){$counts[$b['cat']]=($counts[$b['cat']]??0)+1;} $list=[["name"=>"All Topics","slug"=>"","count"=>count($blogs)]];foreach($counts as $n=>$c){$list[]=["name"=>$n,"slug"=>$n,"count"=>$c];} return $list;}
function getRelatedBlogs(int $currentId,string $currentCat,int $limit=3): array{$all=getAllBlogs();$related=[];foreach($all as $blog){if((int)$blog['id']!==$currentId&&$blog['cat']===$currentCat){$related[]=$blog;if(count($related)>=$limit)return $related;}}foreach($all as $blog){if((int)$blog['id']!==$currentId&&!in_array($blog,$related,true)){$related[]=$blog;if(count($related)>=$limit)return $related;}}return $related;}
