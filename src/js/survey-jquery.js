
$('#activity').on('change', function() {
	if(this.value == 'pp') {
		$('#location').empty().append('<option value="dorms">Dorms</option><option value="lcs">LCs</option><option value="library">Library</option>');
	} else if (this.value == 'ps') {
		$('#location').empty().append('<option value="dorms">Dorms</option><option value="lcs">Classroom 7</option><option value="lcs">Classroom 8</option><option value="lcs">Classroom 9</option><option value="lcs">Classroom 10</option><option value="library">Library</option>');
	} else if (this.value == 'pt') {
		$('#location').empty().append('<option value="dorms">Classroom 3</option><option value="lcs">Classroom 4</option><option value="library">Classroom 5</option><option value="library">Classroom 6</option>');
	} else if(this.value == 'gw') {
		$('#location').empty().append('<option value="dorms">LC foyer</option>');
	} else if (this.value == 'fooo') {
		$('#location').empty().append('<option value="dorms">Integrity</option><option value="lcs">Curiosity</option><option value="library">Excellence</option><option value="library">Humility</option><option value="library">Compassion</option><option value="library">Diversity</option><option value="library">LC foyer</option>');
	}
})
