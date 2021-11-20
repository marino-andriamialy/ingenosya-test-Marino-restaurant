import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DialogRepasComponent } from './dialog-repas.component';

describe('DialogRepasComponent', () => {
  let component: DialogRepasComponent;
  let fixture: ComponentFixture<DialogRepasComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DialogRepasComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DialogRepasComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
