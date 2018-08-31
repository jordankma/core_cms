<?php

namespace Dhcd\Eventsfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Dhcd\Events\App\Repositories\EventsRepository;

use Dhcd\Events\App\Models\Events;

use Validator;

class EventsfrontendController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(EventsRepository $eventsRepository)
    {
        parent::__construct();
        $this->events = $eventsRepository;
    }
    
    public function list(){
        $list_events = Events::all();
        $data = [
            'list_events' => $list_events
        ];
        return view('DHCD-EVENTSFRONTEND::modules.eventsfrontend.list',$data);
    }
}
