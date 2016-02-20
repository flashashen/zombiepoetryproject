package flash.zombie.nlp;

import com.vaadin.data.fieldgroup.BeanFieldGroup;
import com.vaadin.data.fieldgroup.FieldGroup;
import com.vaadin.event.ShortcutAction;
import com.vaadin.ui.*;

/**
 * Created by panelson on 1/10/16.
 */
public class ChompForm extends FormLayout {

    Button save = new Button("Save", this::save);
    Button cancel = new Button("Cancel", this::cancel);
    TextField zombieText = new TextField("Zombie text");
    TextField victimText = new TextField("Victim text");
    Incident transformation;

    // Easily bind forms to beans and manage validation and buffering
    BeanFieldGroup<Incident> formFieldBindings;

    public ChompForm() {
        configureComponents();
        buildLayout();
    }

    private void configureComponents() {

        save.setClickShortcut(ShortcutAction.KeyCode.ENTER);
        setVisible(false);
    }

    private void buildLayout() {
        setSizeUndefined();
        setMargin(true);

        HorizontalLayout actions = new HorizontalLayout(save, cancel);
        actions.setSpacing(true);

        addComponents(actions, zombieText, victimText);
    }

    public void save(Button.ClickEvent event) {
        try {
            // Commit the fields from UI to DAO
            formFieldBindings.commit();

            // Save DAO to backend with direct synchronous service API
             getUI().save(transformation);

            String msg = String.format("Saved '%s %s'.",
                    transformation.getVictimText(),
                    transformation.getZombieText());
            Notification.show(msg, Notification.Type.TRAY_NOTIFICATION);
            getUI().refreshContacts();
        } catch (FieldGroup.CommitException e) {
            // Validation exceptions could be shown here
        }
    }

    public void cancel(Button.ClickEvent event) {
        // Place to call business logic.
        Notification.show("Cancelled", Notification.Type.TRAY_NOTIFICATION);
        getUI().transformationGrid.select(null);
    }

    void edit(Incident transformation) {
        this.transformation = transformation;
        if(transformation != null) {
            // Bind the properties of the contact POJO to fiels in this form
            formFieldBindings = BeanFieldGroup.bindFieldsBuffered(transformation, this);
            victimText.focus();
        }
        setVisible(transformation != null);
    }

    @Override
    public VaadinUI getUI() {
        return (VaadinUI) super.getUI();
    }
}
