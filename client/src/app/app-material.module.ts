import {NgModule} from '@angular/core';
import {
	MatButtonModule, MatCardModule, MatCheckboxModule, MatFormFieldModule, MatInputModule, MatRippleModule
} from '@angular/material';

const modules = [
	MatRippleModule,
	MatButtonModule,
	MatCheckboxModule,
	MatCardModule,
	MatFormFieldModule,
	MatInputModule
];

@NgModule({
	imports: modules,
	exports: modules
})
export class AppMaterialModule {
}