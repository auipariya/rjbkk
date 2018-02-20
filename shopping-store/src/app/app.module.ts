import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppBaseModule } from './app-base/app-base.module';
import { BuyTicketModule } from './buy-ticket/buy-ticket.module';

import { AppComponent } from './app.component';


@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    AppBaseModule,
    BuyTicketModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
