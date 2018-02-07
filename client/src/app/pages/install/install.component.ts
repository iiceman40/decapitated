import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {ObjectHelperService} from '../../helper/objectHelper/object-helper.service';
import {ArrayHelperService} from '../../helper/arrayHelper/array-helper.service';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../../environments/environment';

@Component({
	selector: 'app-install',
	templateUrl: './install.component.html',
	styleUrls: ['./install.component.scss']
})
export class InstallComponent implements OnInit {

	// TODO allow deeper nesting level in html by using recursive structure with templates
	// TODO get server feedback when config could not be written
	// TODO move to reusable component so that the functionality can be used to edit settings, too

	config: any[];
	isArray = ArrayHelperService.isArray;

	constructor(private _route: ActivatedRoute, private _httpClient: HttpClient) {
	}

	ngOnInit() {
		this._route.data.subscribe((data: {configStructure: {}}) => {
			this.config = ObjectHelperService.objectToKeyValueArray(data.configStructure);
		})
	}

	submit() {
		const body = {config: ObjectHelperService.keyValueArrayToObject(this.config)};
		this._httpClient.post(`${environment.apiUri}/system/install`, body).subscribe((response) => {
			console.log(response);
			// TODO get feedback and show to user
		});
	}

}
