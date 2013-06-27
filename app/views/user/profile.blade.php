<div class="well">
    <div class="well-title">Personal Profile</div>
    <div class="row-fluid">
        <div class="span6">
            <label><b>Display name</b></label>
            {{ Form::text('displayName', $activeUser->username." !!!Create the column!!!", array('class' => 'input-block-level', 'placeholder' => 'How a stranger should greet you.')) }}
            <br />

            <label><b>First Name</b></label>
            {{ Form::text('firstName', $activeUser->firstName, array('class' => 'input-block-level', 'placeholder' => 'The goofy name your mom gave you.')) }}
            <br />

            <label><b>Last name</b></label>
            {{ Form::text('lastName', $activeUser->lastName, array('class' => 'input-block-level', 'placeholder' => 'The name you almost never hear.')) }}
            <br />
        </div>
        <div class="span6">
            <label><b>Email Address</b></label>
            {{ Form::text('email', $activeUser->email, array('class' => 'input-block-level', 'placeholder' => 'Your email address.')) }}
            <br />

            <label><b>Location</b></label>
            {{ Form::text('location', "!!!Create the column!!!", array('class' => 'input-block-level', 'placeholder' => 'Where you live?')) }}
            <br />

            <label><b>URL</b></label>
            {{ Form::text('url', "!!!Create the column!!!", array('class' => 'input-block-level', 'placeholder' => 'URL of your site.')) }}
            <br />
        </div>
    </div> 
</div>