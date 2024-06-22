<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\videosDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateVideoFileRequest;
use App\Models\Courses;
use App\Models\Sections;
use App\Models\Videos;
use App\Traits\ImageTrait;
use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
//use ZipArchive;
//use FFMpeg\FFMpeg;
//use FFMpeg\Coordinate\TimeCode;

class VideosController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:display videos', ['only' => ['index']]);
        $this->middleware('permission:delete videos', ['only' => ['destroy']]);
    }

    public function index(Request $request,$course_id,$section_id)
    {
//        return $request->all();

        $videos = Videos::with(['courses'])
            ->where('courses_id',$course_id)
            ->where('section_id',$section_id)
            ->filter($request->all())
            ->paginate(Videos::PAGINATE_NUMBER);
        $courses = Courses::where('id',$course_id)->first();
        if (!$courses){
            return redirect()->back();
        }
        return view('dashboard.videos.index', compact('videos','courses','course_id','section_id'));
    }

    public function create($course_id,$section_id){

        $courses = Courses::where('id',$course_id)->first();
        $sections = Sections::where('id',$section_id)->first();

        if (!$courses){
            return redirect()->back();
        }
        return view('dashboard.videos.create',compact('courses','sections','course_id','section_id'));
    }

    public function store(Request $request){
//        return $request->all();
        $image_path = '';
        $video_path = '';

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image_path = $this->uploadImage('admin', $request->image);
        }
//        if ($request->hasFile('path') && $request->file('path')->isValid()) {
//            $video_path = $this->uploadImage('admin', $request->path);
//        }
//        $extractedFile = $this->getVideoDuration($video_path);


        $courses = Videos::create([
            'courses_id' => $request->courses_id,
            'section_id' => $request->section_id,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_ar,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_ar,
            'status' => '1',
            'image' => $image_path,
            'path' => $request->path,
            'duration' => $request->duration,
        ]);


        toastr()->success(__('messages.Created successfully'));
        return redirect()->route('videos.index',[$request->courses_id,$request->section_id]);
    }


    public function edit($id){
            $video = Videos::find($id);
        return view('dashboard.videos.edit',compact('video'));

    }
    public function update(Request $request,$id)
    {
        $videos = Videos::findorFail($id);

        try {
            $data = $request->all();
            if ($request->has('image')) {
                $image_path = $this->uploadImage('admin', $request->image);
                $data['image'] = $image_path;
                if ($videos->image && File::exists($videos->image)) {
                    File::delete($videos->image);
                }
            }
            $data['title_en'] = $request->title_ar;
            $data['description_en'] = $request->description_ar;

            $videos->update($data);
//
            toastr()->success(__('messages.updated successfully'));
            return redirect()->route('videos.index',[$videos->courses_id,$videos->section_id]);
        } catch (\Exception $ex) {
            toastr()->error(__('messages.There was an error try again'));
            return redirect()->route('videos.edit',$id);
        }
    }

    public function fileuploader(Request $request){
        $places = implode(',', $request->place);
        $gender = implode(',',$request->gender);
        $age = implode(',',$request->age);
//        $muscles_id= implode(',',$request->muscles_id);
        $muscles_id= $request->muscles_id;
//        return $request->all();
        if ($request->hasFile('path') && $request->file('path')->isValid()) {
            $file = $request->file('path');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/zip/', $file_name);
            $file_name = 'uploads/zip/'.$file_name;
//            return $file->getPathname();
            $zip = new ZipArchive;
            if ($zip->open($file_name) === TRUE) {
                $extractedFiles = [];
//                $filename = basename($zip->getNameIndex(1));
//                return pathinfo($filename, PATHINFO_FILENAME);
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    if (str_contains($zip->getNameIndex($i), '__MACOSX'))
                        continue;
                    $filename = $zip->getNameIndex($i);
                    $extractedFiles[] = $filename;
                    $name =pathinfo($filename, PATHINFO_FILENAME);
                    $type = pathinfo($filename, PATHINFO_EXTENSION);
                    if ($type != 'mp4')
                        continue;
                    $extractedFile = new VideosFile();
                    $extractedFile->path = 'uploads/zip/'.$filename;
                    $extractedFile->name = $name;
                    $extractedFile->type = $type;
                    $extractedFile->size = $zip->statIndex($i)['size'];
                    $extractedFile->muscles_id = $muscles_id;
                    $extractedFile->place = $places;
                    $extractedFile->gender = $gender;
                    $extractedFile->age = $age;

                    $zip->extractTo('uploads/zip/', $filename);
                    if ($type == 'mp4'){

                        $extractedFile->duration = $this->getVideoDuration('uploads/zip/'.$filename);
                        $extractedFile->image = $this->getVideoImage('uploads/zip/'.$filename,2,'uploads/image/'.$name.'.jpg');
                    }

                    $extractedFile->save();

                }
                $zip->close();
                unlink($file_name);

            }
            toastr()->success('uploaded successfully!');

            return redirect()->route('videosFile.create');
            }else{
            toastr()->error('Error!','Error!');
            return redirect()->route('videosFile.create');

        }

    }
//    public function getVideoDuration($videoPath)
//    {
//        // تحديد مسار تنصيب الأداة الفعلية ffmpeg
////        Config::set('ffmpeg', '/path/to/ffprobe');
//
//        $ffmpeg = FFMpeg::create();
//        $video = $ffmpeg->open($videoPath);
//
//        // احصل على مدة الفيديو بالثواني
//        $durationInSeconds = $video->getStreams()->first()->get('duration');
//
//        // احسب المدة بالدقائق والثواني
//        $minutes = floor($durationInSeconds / 60);
//        $seconds = $durationInSeconds % 60;
//
//        // قم بإعادة المدة بتنسيق الدقائق:الثواني
//        return $minutes.':'.$seconds;
//    }
//    public function getVideoImage($videoPath,$time,$imageName){
//        $ffmpeg = FFMpeg::create();
//
//        $video = $ffmpeg->open($videoPath);
//
//        $frame = $video->frame(TimeCode::fromSeconds($time));
//
//        $thumbnailPath = public_path($imageName);
//        $frame->save($thumbnailPath);
//        return $imageName;
//
//    }

    public function destroy($id)
    {
        try {
            $videosFile = Videos::find($id);
            if (!$videosFile) {
                toastr()->error(__('messages.The Video is not exist'));
                return redirect()->route('videosFile.index');
            }

            if (File::exists($videosFile->path)) {
                File::delete($videosFile->path);
            }
            if (File::exists($videosFile->image)) {
                File::delete($videosFile->image);
            }

            $videosFile->delete();

        } catch (\Exception $ex) {
            toastr()->error(__('messages.There was an error try again'));
            return redirect()->route('videosFile.index');
        }
    }

    public function setVideoThumbnail($id)
    {
        $video = VideosFile::find($id);
        $filename = pathinfo($video->path, PATHINFO_FILENAME);
        $video->update(['image' => $this->getVideoImage($video->path,2,'uploads/image/'.$filename.'.jpg')]);
        return response()->json('Success');
    }

}
