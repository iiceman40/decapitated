import {Component, OnInit} from '@angular/core';
import {AuthService} from '../../services/authService/auth.service';

@Component({
	selector: 'app-home',
	templateUrl: './home.component.html',
	styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

	constructor(private _authService: AuthService) {
	}

	ngOnInit() {
	}

	// TODO move logout button to general header component
	logout() {
		this._authService.logout();
	}
}
