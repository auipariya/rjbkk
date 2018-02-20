import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { BuyTicketComponent } from './buy-ticket.component';

const BUY_TICKET_ROUTE: Routes = [
  {
    path: 'buy-ticket',
    component: BuyTicketComponent
  }
];


@NgModule({
  imports: [RouterModule.forChild(BUY_TICKET_ROUTE)],
  exports: [RouterModule]
})
export class BuyTicketRoutingModule { }
