import { Component, OnInit } from '@angular/core';
import { Router, Route } from '@angular/router';

@Component({
  selector: 'app-nav-header',
  templateUrl: './nav-header.component.html',
  styleUrls: ['./nav-header.component.scss']
})
export class NavHeaderComponent implements OnInit {

  pathConfig: PathConfig[] = [];

  constructor(
    private router: Router
  ) { }

  ngOnInit() {
    this.pathConfig = this.router.config.map((route: Route) => {
      return {
        name: route.path,
        url: route.path.split('-').join(' ')
      } as PathConfig;
    });
    console.log(this.pathConfig);
  }

}

interface PathConfig {
  name: string;
  url: string;
}