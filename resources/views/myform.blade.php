<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

@if (count($errors) > 0)
   <div class = "alert alert-danger">
      <ul>
         @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
@endif

{{ Form::open(['url'=>'registration','files'=>true]) }}


{{ Form::label('Email')}}
{{ Form::text('email','example@abc.com') }}
<?= '<br/>' ?>

{{ Form::label('User Name')}}
{{ Form::text('username') }}
<?= '<br/>' ?>

{{ Form::label('Password')}}
{{ Form::password('password') }}
<?= '<br/>'?>
{{ Form::label('Gender')}}
{{ Form::select('select', array('M' => 'Male', 'F' => 'Female')) }}
<?= '<br/>' ?>

{{ Form::label('Image')}}
{{ Form::file('image') }}
<?= '<br/>' ?>

{{ Form::label('Agree Term & Condition')}}
{{ Form::checkbox('check', 'value')}}
<?= '<br/>' ?>

{{ Form::submit('Register') }}

{{    Form::close() }}

