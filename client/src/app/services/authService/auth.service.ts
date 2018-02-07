import {Injectable} from '@angular/core';
import {Router} from '@angular/router';
import {JwtHelper} from 'angular2-jwt';

@Injectable()
export class AuthService {

	constructor(private _jwtHelper: JwtHelper, private _router: Router) {
	}

	public getToken(): string {
		return localStorage.getItem('token');
	}

	public setToken(token: string) {
		return localStorage.setItem('token', token);
	}

	public isAuthenticated(): boolean {
		const token = this.getToken();
		if(token) {
			// const decodedToken = this._jwtHelper.decodeToken(token);
			// const expirationDate = this._jwtHelper.getTokenExpirationDate(token);
			const isExpired = this._jwtHelper.isTokenExpired(token);

			// console.log(decodedToken, expirationDate, isExpired);
			console.log(!isExpired);
			return !isExpired;
		}

		return false;
	}

	public logout() {
		localStorage.removeItem('token');
		this._router.navigate(['/login']);
	}

}
