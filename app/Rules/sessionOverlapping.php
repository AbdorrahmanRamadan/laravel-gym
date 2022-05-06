<?php

namespace App\Rules;

use App\Models\TrainingSession;
use Illuminate\Contracts\Validation\Rule;

class sessionOverlapping implements Rule
{
    private $start_time;
    private $end_time;
    private $gym_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start_at,$end_at,$gym_id)
    {
        $this->start_time =$start_at;
        $this->end_time = $end_at;
        $this->gym_id = $gym_id;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $sessions = TrainingSession::where('gym_id',$this->gym_id)->get();
        if($sessions)
        {
            foreach ($sessions as $session) {
                if((strtotime($this->start_time) > strtotime($session->start_at) && strtotime($this->start_time) < strtotime($session->end_at) )||(strtotime($session->start_at) > strtotime($this->start_time) && strtotime($session->start_at)  < strtotime($this->end_time) ))
                {
                    return false;
                }
            }
            return true;
        }
        else
        {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Session overlap. Please change the time.';
    }
}
