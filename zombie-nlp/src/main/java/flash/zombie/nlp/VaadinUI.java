package flash.zombie.nlp;


import com.vaadin.annotations.Theme;
import com.vaadin.data.util.BeanItemContainer;
import com.vaadin.server.VaadinRequest;
import com.vaadin.spring.annotation.SpringUI;
import com.vaadin.ui.*;

import java.util.ArrayList;

@SpringUI
@Theme("reindeer")
public class VaadinUI extends UI {



    TextField filter = new TextField();
    Grid transformationGrid = new Grid();
    Button newTransformation = new Button("New transformation");
    ChompForm chompForm = new ChompForm();
    ArrayList<Incident> transformations;

    @Override
    protected void init(VaadinRequest request) {
        configureComponents();
        buildLayout();

    }

    public void save(Incident transformation){
        transformations.add(transformation);
    }

    private void configureComponents() {

        // Dummy data
        Incident at = new Incident();
        Incident bt = new Incident();
        at.zombieText = "a z text";
        at.victimText = "a v text";
        bt.zombieText = "b z text";
        bt.victimText = "b v text";
        transformations = new ArrayList<>();
        transformations.add(at);
        transformations.add(bt);


        chompForm = new ChompForm();

        newTransformation.addClickListener(e -> chompForm.edit(new Incident()));

        filter.setInputPrompt("Filter chomps...");
        filter.addTextChangeListener(e -> refreshContacts(e.getText()));

        transformationGrid.setContainerDataSource(new BeanItemContainer<>(Incident.class));
//        transformationGrid.setColumnOrder("firstName", "lastName", "email");
//        transformationGrid.removeColumn("victimParseTrees");
//        transformationGrid.removeColumn("zombieParseTrees");
//        transformationGrid.setSelectionMode(Grid.);
        transformationGrid.addSelectionListener(e
                -> chompForm.edit((Incident) transformationGrid.getSelectedRow()));
        refreshContacts();
    }

   private void buildLayout() {

        HorizontalLayout actions = new HorizontalLayout(filter, newTransformation);
        actions.setWidth("100%");
        filter.setWidth("100%");
        actions.setExpandRatio(filter, 1);

        VerticalLayout left = new VerticalLayout(actions, transformationGrid);
        left.setSizeFull();
        transformationGrid.setSizeFull();
        left.setExpandRatio(transformationGrid, 1);

        HorizontalLayout mainLayout = new HorizontalLayout(left, chompForm);
        mainLayout.setSizeFull();
        mainLayout.setExpandRatio(left, 1);

        // Split and allow resizing
        setContent(mainLayout);
    }

    void refreshContacts() {
        refreshContacts(filter.getValue());
    }

    private void refreshContacts(String stringFilter) {
        transformationGrid.setContainerDataSource(new BeanItemContainer<>(
                Incident.class, transformations));
        chompForm.setVisible(false);
    }





//    @Override
//    protected void init(VaadinRequest request) {
//        setContent(new Button("Click me", e->Notification.show("Hello Spring+Vaadin user!")));
//
//        // Create a Grid and data-bind the Person objects.
//        Incident at = new Incident();
//        Incident bt = new Incident();
//        at.zombieText = "a z text";
//        at.victimText = "a v text";
//        bt.zombieText = "b z text";
//        bt.victimText = "b. v text";
//        ArrayList<Incident> list = new ArrayList<>();
//        list.add(at);
//        list.add(bt);
//
//        Grid grid = new Grid();
//        grid.setContainerDataSource(
//                new BeanItemContainer<Incident>(Incident.class, list));
//    }
}