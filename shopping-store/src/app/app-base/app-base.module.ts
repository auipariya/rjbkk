import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AppRoutingModule } from './/app-routing.module';
import { NavHeaderComponent } from './nav-header/nav-header.component';


@NgModule({
  imports: [
    CommonModule,
    AppRoutingModule
  ],
  declarations: [
    NavHeaderComponent
  ],
  exports: [
    AppRoutingModule,
    NavHeaderComponent
  ]
})
export class AppBaseModule { }
