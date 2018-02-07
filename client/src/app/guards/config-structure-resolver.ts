import {Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, Resolve, Router, RouterStateSnapshot} from '@angular/router';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

@Injectable()
export class ConfigStructureResolver implements Resolve<{}> {

	constructor(private _httpClient: HttpClient, private _router: Router) {}

	resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): {} {
		// TODO route to error page if something goes wrong
		return this._httpClient.get(`${environment.apiUri}/system/getConfig`);
	}

}