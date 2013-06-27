<?php

class ManageController extends BaseController {

	public function getIndex()
	{
		$episodes = Episode::orderBy('date', 'desc')->get();

		$this->setViewData('episodes', $episodes);
	}

	public function getAdd()
	{
		// Get all data
		$series   = $this->arrayToSelect(Series::orderByNameAsc()->get());
		$games    = $this->arrayToSelect(Game::orderByNameAsc()->get());
		$episodes = $this->arrayToSelect(Episode::orderBy('title', 'asc')->get(), 'id', 'title');

		$this->setViewData('series', $series);
		$this->setViewData('games', $games);
		$this->setViewData('episodes', $episodes);
	}

	public function postAdd()
	{
		$input = e_array(Input::all());

		if ($input != null) {
			$episode               = new Episode;
			$episode->series_id    = $input['series_id'];
			$episode->game_id      = $input['game_id'];
			$episode->parentId     = ($input['parentId'] > 0 ? $input['parentId'] : null);
			$episode->seriesNumber = $input['seriesNumber'];
			$episode->title        = $input['title'];

			$link = str_replace('http://www.youtube.com/watch?v=', '', $input['link']);

			if (strpos($link, '?')) {
				$link = substr($link, 0, strpos($input['link'], '?'));
			}

			$episode->link = $link;
			$episode->date = date('Y-m-d', strtotime($input['date']));

			$episode->save();

			if (count($episode->getErrors()->all()) > 0) {
				return Redirect::to(Request::path())->with('errors', $episode->getErrors()->all());
			} else {
				if (isset($input['continue'])) {
					return Redirect::to(Request::path())->with('message', $episode->game->name .' '. $episode->seriesNumber .':'. $episode->title .' has been submitted.');
				} else {
					return Redirect::to('/manage')->with('message', $episode->game->name .' '. $episode->seriesNumber .':'. $episode->title .' has been submitted.');
				}
			}
		}
	}

	public function getEdit($episodeId)
	{
		$episode  = Episode::find($episodeId);
		$series   = $this->arrayToSelect(Series::orderByNameAsc()->get());
		$games    = $this->arrayToSelect(Game::orderByNameAsc()->get());
		$episodes = $this->arrayToSelect(Episode::orderBy('title', 'asc')->get(), 'id', 'title');

		$this->setViewData('episode', $episode);
		$this->setViewData('series', $series);
		$this->setViewData('games', $games);
		$this->setViewData('episodes', $episodes);
	}

	public function postEdit($episodeId)
	{
		$input = e_array(Input::all());

		if ($input != null) {
			$episode               = Episode::find($episodeId);
			$episode->series_id    = $input['series_id'];
			$episode->game_id      = $input['game_id'];
			$episode->parentId     = ($input['parentId'] > 0 ? $input['parentId'] : null);
			$episode->seriesNumber = $input['seriesNumber'];
			$episode->title        = $input['title'];

			$link = str_replace('http://www.youtube.com/watch?v=', '', $input['link']);

			if (strpos($link, '?')) {
				$link = substr($link, 0, strpos($input['link'], '?'));
			}

			$episode->link = $link;
			$episode->date = date('Y-m-d', strtotime($input['date']));

			$episode->save();

			if ($episode === true && count($episode->getErrors()->all()) > 0) {
				return Redirect::to(Request::path())->with('errors', $episode->getErrors()->all());
			} else {
				return Redirect::to('/manage')->with('message', $episode->game->name .' '. $episode->seriesNumber .':'. $episode->title .' has been submitted.');
			}
		}
	}

	public function getWinners($episodeId)
	{
		$episode = Episode::find($episodeId);
		$teams   = $this->arrayToSelect(Team::orderByNameAsc()->get());
		$members = $this->arrayToSelect(Member::orderByNameAsc()->get());

		$this->setViewData('episode', $episode);
		$this->setViewData('teams', $teams);
		$this->setViewData('members', $members);
	}

	public function postWinners($episodeId)
	{
		$input  = Input::all();
		$errors = array();

		// Handle the form data
		if ($input != null) {

			// Get the episode
			$episode = Episode::find($episodeId);

			// Only run if any members are added
			if (count($input['members']) > 0) {

				foreach ($input['members'] as $member) {

					// Skip any with no member selected
					if ($member == 0) {
						continue;
					}

					// Check if this record exists already
					$existingWinner = Episode_Win::where('episode_id', '=', $episode->id)->where('winmorph_id', '=', $member)->where('winmorph_type', '=', 'Member')->first();

					// Create the record if one does not exist
					if (!isset($existingWinner->id)) {
						$win                = new Episode_Win;
						$win->episode_id    = $episode->id;
						$win->winmorph_id   = $member;
						$win->winmorph_type = 'Member';
						$win->save();

						// Set any errors
						if (count($win->getErrors()->all()) > 0){
							$errors[] = implode('<br />', $win->getErrors()->all());
						}
					}
				}
			}

			// Only run if any teams are added
			if (count($input['teams']) > 0) {

				foreach ($input['teams'] as $team) {
					// Skip any with no team selected
					if ($team == 0) {
						continue;
					}

					// Check if this record exists already
					$existingWinner = Episode_Win::where('episode_id', '=', $episode->id)->where('winmorph_id', '=', $member)->where('winmorph_type', '=', 'Team')->first();

					// Create the record if one does not exist
					if (!isset($existingWinner->id)) {
						$win                = new Episode_Win;
						$win->episode_id    = $episode->id;
						$win->winmorph_id   = $team;
						$win->winmorph_type = 'Team';
						$win->save();

						// Set any errors
						if (count($win->getErrors()->all()) > 0){
							$errors[] = implode('<br />', $win->getErrors()->all());
						}
					}
				}
			}

			if (count($errors) > 0){
				return Redirect::to(Request::path())->with('errors', $errors);
			} else {
				return Redirect::to('/manage')->with('message', 'Winners added to '. $episode->name.'.');
			}
		}
	}
}