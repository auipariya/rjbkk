import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const APP_ROUTE:Routes = [
  {
    path: '',
    redirectTo: 'buy-ticket',
    pathMatch: 'full'
  }
];


@NgModule({
  imports: [
    RouterModule.forRoot(APP_ROUTE)
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
