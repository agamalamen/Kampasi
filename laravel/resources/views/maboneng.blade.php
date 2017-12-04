@extends('layouts.app')
@section('title') Error 404: Justice not found. @endsection

<style>
		body {
			background-color: white !important;
			color: #333 !important;
		}
</style>

<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<h1 style="margin-bottom: 50px;">Error 404: Justice not found. <span style="font-size: 12px;" class="pull-right">{{Auth::User()->school->mabonengs->count()}} endorsed this. 
@if(Auth::User()->maboneng)
<span class="btn-md text-muted">Endorsed</span>
@else
<a href="{{route('get.maboneng')}}" class="btn btn-primary btn-md">Endrosed this</a></span>
@endif
</h1>
<p style="font-family: lato; font-size: 18px; line-height: 30px;">
In previous meetings, Dean Hatim has been beyond reproach. However, in this Dean’s Talk, I was able to count many flaws in his responses. The clear injustice committed against the Maboneng case students this time, was bigger than any well-articulated words to cover. 
<br><br>
After finishing the meeting with Dean Hatim, I went to my room and slept for four hours. When I woke up I thought the school would be upside down. I checked the group just to see a lost ring in LCs, someone looking for oil, and a cancelled Town Hall meeting. The meeting was postponed because of the approaching exams. The exams that we are willing to have a Town Hall meeting for, send mass emails, drown the group with posts and plan for sit-ins. But also because of the exams we are not willing to waste one hour of our time to protect each other. LONG LIVE THE EXAMS!
<br><br>
Our five core values were never mentioned in a hierarchical order until the school decided to give much weight to one value and marginalize the others for the sake of protecting its position against these students. Not just they put much emphasis on Integrity they also narrowed down its definition to serve their own point of view and address them with such a cruel punishment. Dishonesty is not just lying. Dishonesty is demonstrated every day on campus in tens of instances by the students. From cheating in exams, spreading rumors, lying about the reason for missing class, stealing snack, to faking promises in elections. We are just lucky dishonest people that happened to post on Snapchat while snitches were not online. However, this is not as important in the eyes of the school compared to the great sin of lying in the glorious DC room in the holy presence of the DC committee. 
<br><br>

It was mentioned by Dean Hatim that each case was treated individually, they all still got the same punishment anyway. It is a fatal act of injustice as this punishment is a well anticipated four weeks of holiday for some of them and a decision that holds a lot of damage for others. I am not sure if the school is expecting that with this punishment the student body will have a sincere interest in Integrity for its sake, or will be honest for sake of coming out from the DC room with the least consequences. 
<br><br>
When I first met Laila, my PC daughter, after hearing her decision, I did not know what to say. She started by explaining to me the reason why she consumed alcohol at first place. She then affirmed to me that she will be there tomorrow for PC lunch not like last time. I have no knowledge of the underlying values that let someone say these things during a time like this, but I know they must outweigh the crappy definition of integrity in the Academy. She later told me that she will miss the TED talk that she was supposed to give recently and will also miss on going to Harvard as part of IRC. nevertheless, to mention the second year students who will have this case reported to college. A consequence that is only damaging to those who are still in their early stage of college process which does not apply to all. Once again, the school is cultivating the culture of Just-be-careful-until-you-get-into-college-and-then-do-what-you-want. A huge lack of consideration and compassion that should have been put in these cases, rather were put in <b>another</b>.
<br><br>

<ul style="font-family: lato; font-size: 18px; line-height: 30px;">
	<li>I address the school to revise all cases of these students all over again. Putting all of the school’s values into equal consideration. Blaming them for a one time infraction in Integrity, being Compassionate with them for their continuous Excellence and Curiosity, and for the school to have enough Humility to admit their mistake against them and take the proper procedures to fix it.</li>
<br>

	<li>I address the school to form a committee for auditing all the gaps in the handbook highlighted by the students in the auditorium. Apparently, it makes more sense not to alter the handbook when it's most convenient to the admin but when it is most needed by the students. Reviews to be started by January.</li>
<br>
	<li>I address the students to stop any ongoing activity/club until all the cases of these students are properly revised. Without reinvestigation in these cases, Kampasi ceases to exist. As Sammy once put it: “We are ALA”. Without us, and without what we bring to the school, the school ceases to exists as well. For this, we should all “be careful” that this might happen to any of us, and for this, we should all protect each other.</li>

</ul>

	<span style="padding-bottom: 30px; font-family: lato; font-size: 18px; line-height: 30px;">- Ahmed Gamal</span>
	<br>
<span style="font-size: 12px; margin-bottom: 20px;" class="pull-right">{{Auth::User()->school->mabonengs->count()}} endorsed this. 
@if(Auth::User()->maboneng)
<span class="btn-md text-muted">Endorsed</span>
@else
<a href="{{route('get.maboneng')}}" class="btn btn-primary btn-md">Endrose this</a></span>
@endif

			</div><!-- col-md-10 -->
	</div><!-- row -->

</div><!-- container -->