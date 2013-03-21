ALTER TABLE documents DROP CONSTRAINT documents_experiment__id_fkey;
ALTER TABLE documents DROP CONSTRAINT documents_trial__id_fkey;

ALTER TABLE documents ADD FOREIGN KEY (experiment__id) REFERENCES experiments(experiment_id) ON DELETE CASCADE;
ALTER TABLE documents ADD FOREIGN KEY (trial__id) REFERENCES trials(trial_id) ON DELETE CASCADE;

